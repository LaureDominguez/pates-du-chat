<?php

namespace Controllers;

use \Models\Users;
use \Models\Mail;

class UsersController{

////////////////////////// check session //////////////////////////

    public function isConnected()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=home');
            $errors = "Veuillez vous authentifier";
            $_SESSION['visitor']['flash_message']['error'] = [
                'login' => $errors
            ];
        }
    }

////////////////////////// Profil //////////////////////////

    public function profil()
    {//affiche le compte user
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);

        $description = "Mon compte";
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

////////////////////////// register //////////////////////////

    public function newUser()
    { //création d'un nouveau compte user
        //check si email deja utilisé
        $errors = [];
        $success = "";
        $model = new Users();
        $sendMail = new Mail();

        $isUsed = $model->checkEmail(trim($_POST['email']));

        if($isUsed !== false){ 
            // si error on arrete le script et renvoi l'erreur
            $errors = "Cet email est déjà utilisé";
            $_SESSION['visitor']['flash_message']['error'] = [
                'register' => $errors
            ];
            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit;
        } else {
            //sinon on créer le compte
            $token = bin2hex(random_bytes(16));
            $expiration = time() + (7 * 24 * 60 * 60); // le lien expire dans 7jours

            $newUser = [
                trim($_POST['email']),
                password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT),
                $token,
                $expiration
            ];

            $newID = $model->creatNew($newUser);

            //recupère l'id créé pour le connecter directement
            $newUser = $model->getUser($newID);

            $_SESSION['user'] = [
                'id' => $newUser['id'],
                'email' => $newUser['email'],
                'name' => $newUser['name'],
                'role' => $newUser['role']
            ];

            //envoie le mail de bienvenue et de vérif
            $sendMail->welcomeMessage($newUser);
            $sendMail->VerifMessage($newUser);

            $success = "Votre compte a bien été créé !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: ' . $_SESSION['visitor']['currentPage']);
        }
    }

////////////////////////// connexion //////////////////////////

    public function loginUser()
    { //connexion à un compte
        $errors = [];
        $success = "";
        $email = trim($_POST['email']);
        $model = new Users();

        //check si l'email est dans la db
        $userExist = $model->checkEmail($email);

        if(!$userExist){
            $errors[] = "L'email ou le mot de passe est incorrect";
            $_SESSION['visitor']['flash_message']['error'] = [
                'login' => $errors
            ];
            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit();
        } else { // si oui, récup les infos
            $user = $model->getUser($userExist['id']);
            $pswd = trim($_POST['pswd']);

            if (password_verify($pswd, $user['pswd'])){
                if($user['disabled']===1){
                    $errors[] = "Ce compte semble avoir été désactivé";
                    $_SESSION['visitor']['flash_message']['error'] = [
                        'login' => $errors
                    ];
                } else {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'role' => $user['role']
                    ];

                    //si user a un nom, alors on l'appelle par son nom, sinon par email
                    $userName = isset($user['name']) ? $user['name'] : $user['email'];

                    //si user a le role admin, alors on le lui dit
                    if ($user['role'] == 1) {
                        $success = "Bienvenue admin " . $userName;
                        $_SESSION['admin']['adminToken'];
                    } else {
                        $success = "Bienvenue, " . $userName;
                    }

                    $_SESSION['visitor']['flash_message'] = [
                        'success' => $success
                    ];
                }
            } else {
                $errors[] = "L'email ou le mot de passe est incorrect";
                $_SESSION['visitor']['flash_message']['error'] = [
                    'login' => $errors
                ];
            }
        }
        header('Location: ' . $_SESSION['visitor']['currentPage']);
        exit();
    }
    
    ////////////////////////// validate email //////////////////////////
    public function validateEmail($token, $email)
    {
        $errors = [];
        $success = "";
        $model = new Users();

        $userExist = $model->checkEmail($email);

        if (!$userExist) {
            $errors[] = "Utilisateur inconnu";
        } else {
            $user = $model->getUser($userExist['id']);
            $current_time = time();
            if ($token === $user['token'] && $current_time <= $user['expiration']){
                // on confirme l'activation du compte dans la db
                $newData = [
                    'id'=> $user['id'],
                    'activate' => 1
                ];
                $model->updateUser($newData);

                // on connecte l'utilisateur
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];

                $success = "Votre compte est correctement activé";

            } else {
                $errors[] = "Le lien a expiré";
            }

            if (count($errors) == 0){
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];
            } else {
                $_SESSION['visitor']['flash_message'] = [
                    'error' => $errors
                ];
            }

            header('Location: index.php?route=home');
            exit();
        }
    }

    ////////////////////////// update //////////////////////////

    public function replaceSpecialChar($string)
    {
        $string =  "";
        return str_replace([",", "<", ">", "!"], "", $string);
    }

    public function updateUserName()
    {//création ou modification du nom de user
        $errors = [];
        $success = $name = "";

        if (isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $this->replaceSpecialChar($name);

            if (empty($name)) {
                $errors[] = "Veuillez entrer votre nom";
            }

            if (count($errors) == 0) {
                $newData = [
                    'id' => $_SESSION['user']['id'],
                    'name' => $name
                ];
                $model = new Users();
                $model->updateUser($newData);

                $_SESSION['user']['name'] = $name;

                $success = "Votre nom a bien été modifié !";
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];

                header('Location: index.php?route=myAccount');
                exit();
            }
        }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];

        $description = "Erreur lors de la modification du compte";
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    public function resetForm($token, $email)
    { //affiche le formulaire pour reset le mdp
        $model = new Users();
        $userExist = $model->checkEmail($email);
        $errors = [];

        if($userExist) {
            $user = $model->getUser($userExist['id']);
            $current_time = time();
            
            if ($token === $user['token'] && $current_time <= $user['expiration']) {

                $template = "users/resetForm.phtml";
                $description = "Réinitialisation du mot de passe";
                include_once 'views/layout.phtml';
            } else {
                $errors[] = "Le lien a expiré";
            }
        } else {
            $errors[] = "Utilisateur inconnu";
        }
        if (!empty($errors)) {
            $_SESSION['visitor']['flash_message'] = [
                'error' => $errors
            ];
            header('Location: index.php?route=home');
            exit();
        }
    }

    public function resetPswd()
    { // envoi du reset du password de user
        $errors = [];
        $success = "";

        if (isset($_POST['pswd_rst'])) {
            $email = trim($_POST['email_rst']);

            // on retrouve les info de l'utilisateur
            $model = new Users();
            $userId = $model->checkEmail($email)['id'];

            $resetUser = [
                'id' => $userId,
                'email' => $email,
                'pswd' => password_hash(trim($_POST['pswd_rst']), PASSWORD_DEFAULT)
            ];

            // update user
            $model->updateUser($resetUser);

            // on recup info à jour de user pour le connecter
            $user = $model->getUser($userId);

            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'role' => $user['role']
            ];

            $success = "Votre mot de passe a bien été modifié !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: index.php?route=myAccount');
            exit();
        }
        $errors[] = "Une erreur est survenu lors de la modification de votre mot de passe";
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];

        $description = "Erreur lors de la modification du mot de passe";
        $template = "users/reset.phtml";
        include_once 'views/layout.phtml';
    }

    ////////////////////////// logout //////////////////////////
    public function logout()
    { //deconnexion de la session 'user'
        session_destroy();
        $currentPage = $_SESSION['visitor']['currentPage'];

        if ($currentPage == 'myAccount' || $currentPage == 'myShopCart' || $currentPage == 'admin') {
            header('Location: index.php?route=home');
        } else {
            header('Location: ' . $currentPage);
        }
    }

    ////////////////////////// Disable //////////////////////////
    public function disable()
    {
        $userId = $_SESSION['user']['id'];
        $randomPswd = $this->generatePswd();
        $newData = [
            'email' => 'disabled-account' . $userId,
            'name' => null,
            'pswd' => $randomPswd,
            'role' => 0,
            'disabled' => 1
        ];
        $model = new Users();
        $model->updateUser($newData);
        $success = "Votre compte a bien été supprimé";
        $_SESSION['visitor']['flash_message'] = [
            'success' => $success
        ];
        $this->logout();
    }

    function generatePswd($length = 40)
    {
        $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
        $charactersLength = strlen($characters);
        $Pswd            = '';
        for ($i = 0; $i < $length; $i++) {
            $Pswd .= $characters[rand(0, $charactersLength - 1)];
        }
        return $Pswd;
    }
}
