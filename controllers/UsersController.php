<?php

namespace Controllers;

use \Models\Users;

class UsersController{

////////////////////////// routes //////////////////////////
    public function profil()
    {//affiche le compte user
        $model = new Users();
        // $user = $model->getUser($_SESSION['user']['id']);

        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    public function cart()
    {//affiche le panier de l'utilisateur (gestion dans ShopCartController)
        $model = new Users();
        // $user = $model->getUser($_SESSION['user']['id']);
        $model = new ShopCartController();

        $template = "users/cart.phtml";
        include_once 'views/layout.phtml';
    }

    public function logout()
    {//deconnexion de la session 'user'
        session_destroy();
        $currentPage = $_SESSION['visitor']['currentPage'];
        if($currentPage = 'myAccount' || 'myShopCart' || 'admin'){
            header('Location: index.php?route=home');
            exit();
        }
        header('Location: ' . $currentPage);
        exit();
    }

////////////////////////// register //////////////////////////
    public function newUser()
    {//création d'un nouveau compte user
            
        $newUser = [
            trim($_POST['email']),
            password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT),
        ];

        $model = new Users();
        $model->creatNew($newUser);


        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //MODIF DU NEW USER ID DANS DB

        // if (isset($_SESSION['visitor']) && !isset($_SESSION['user']))
        // $_SESSION['visitor']['id'] = $newID;

        // A CORRIGER
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        //recupère l'id créé pour le connecter directement
        $newID = $_SESSION['visitor']['id'];
        $newUser = $model->getUser($newID);

        $_SESSION['user'] = [
            'id' => $newUser['id'],
            'email' => $newUser['email'],
            'name' => $newUser['name'],
            'role' => $newUser['role']
        ];

        $success = "Votre compte a bien été créé !";
        $_SESSION['visitor']['msg'] = [
            'success' => $success
        ];
            // }
        // }
        header('Location: ' . $_SESSION['visitor']['currentPage']);
    }

////////////////////////// connexion //////////////////////////
    public function checkUser()
    { //connexion d'un compte user
        // $input = json_decode(file_get_contents('php://input'), true);

        $errors = $errors_email = $errors_pswd = $userExist = [];
        $email = $pswd = $emailUsed  = $success = "";

        // if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {

            //validation email
            $email = trim($_POST['email']);

            //si erreur, alors stock le message d'erreur
            // if (empty($email))
            // $errors[] = $errors_email[] = "Veuillez saisir un email";
            // else
            // switch ($email) {
            //     case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
            //         $errors[] = $errors_email[] = "Email ou mot de passe incconu";
            //         break;
            //     case !empty($email):
                    $model = new Users();
                    $emailUsed = $model->checkEmail($email);
                    // if (empty($emailUsed))
                    //     $errors[] = $errors_email[] = "Email ou mot de passe incconu";
                    // if (!empty($emailUsed))
                        // $model = new Users();
                    $userExist = $model->getUser($emailUsed['id']);
                    // break;
            // }


            //validation mot de passe
            // if (empty($_POST['pswd']))
            // $errors[] = $errors_pswd[] = "Veuillez entrer votre mot de passe";

            //si erreur, alors stock dans la session visitor
            // echo json_encode($errors);
            // echo json_encode($errors_email);
            // echo json_encode($errors_pswd);
            // echo json_encode($errors_verif);

            // $_SESSION['visitor']['msg'] = [
            //     'log_email_errors' => $errors_email,
            //     'log_pswd_errors' => $errors_pswd,
            // ];

            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);
            //si pas d'erreur, alors créer la session user. else à la fin
            if (count($errors) == 0) {
                if (password_verify($pswd, $userExist['pswd'])) {
                    $_SESSION['user'] = [
                        'id' => $userExist['id'],
                        'email' => $userExist['email'],
                        'name' => $userExist['name'],
                        'role' => $userExist['role']
                    ];

                    $user = "";
                    //si user a un nom, alors on l'appelle par son nom, sinon par email
                    if (isset($userExist['name'])) {
                        $user = $userExist['name'];
                    } else {
                        $user = $userExist['email'];
                    }

                    //si user a le role admin, alors on lui dit
                    if ($userExist['role'] == 1) {
                        $success = "Bienvenue admin " . $userExist['email'];
                        $_SESSION['admin'] = [
                            'dashboardPages' => [
                                'tab1' => 'checked',
                                'tab2' => '',
                                'tab3' => '',
                                'tab4' => '',
                            ]
                        ];
                    } else
                        $success = "Bienvenue, " . $user;

                    // $_SESSION['visitor']['msg'] = [
                    //     'success' => $success,
                    // ];

                    header('Location: index.php?route=home');
                    exit;
                } else $errors[] = $errors_email[] = "Email ou mot de passe incconu";

                //sinon on affiche les erreurs
                // echo json_encode($errors);
                // return json_encode($errors);
                // $_SESSION['visitor']['msg'] = [
                //     'log_email_errors' => $errors_email,
                //     'log_pswd_errors' => $errors_pswd,
                // ];
            }

            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit;
        // }
    }

    ////////////////////////// check session //////////////////////////

    public function isConnected()
    {
        if (!isset($_SESSION['user']))
            header('Location: index.php?route=login');
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
        $name = $success = "";
        if (array_key_exists('name', $_POST)) {

            $name = trim($_POST['name']);
            $this->replaceSpecialChar($name);

            if (empty($name))
                $errors[] = "Veuillez entrer votre nom";
            }

            $_SESSION['visitor']['msg'] = [
                'name_error' => $errors,
            ];

            if (count($errors) == 0) {

                $model = new Users();
                $model->updateUser($name);

                $_SESSION['user']['name']=$name;

                $success = "Votre nom a bien été modifié !";
                $_SESSION['visitor']['msg'] = [
                    'name_success' => $success,
                ];
                
                header('Location: index.php?route=myAccount');
                exit();
            }
        $_SESSION['visitor']['msg'] = [
            'name_error' => $errors,
        ];
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }
}