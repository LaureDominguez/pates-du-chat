<?php

require_once './models/Database.php';
require_once './models/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $users = new Models\Users();
        $input = json_decode(file_get_contents('php://input'), true);
        $errors = [];

        if (isset($input['pswd_confirm'])) 
        { ////////////////// check for register ///////////////////////
                $checkEmail = $users->checkEmail("SELECT id FROM users WHERE email = :email");
                if ($checkEmail === true) {
                        $errors['mail'] = "Cet email est déjà utilisé";
                }
        } 
        else 

        { ///////////////// check for login ////////////////////////////////

                // Récupère user avec son email
                $user = $database->findOne("SELECT * FROM users WHERE email = :email", ['email' => $input['email']]);
                if ($user) {
                        // Test si les mots de passe matchent
                        $stockedPaswd = $user['pswd'];
                        $pswd = $input['pswd'];
                        // $pswd = password_hash(trim($input['pswd']), PASSWORD_DEFAULT);
                        if ($pswd === $stockedPaswd) {
                        // if (password_verify($pswd, $stockedPaswd)) {
                                // Mot de passe correct
                                // Vous pouvez effectuer d'autres actions, par exemple, créer une session utilisateur ici
                                // Par exemple :
                                // session_start();
                                // $_SESSION['user_id'] = $user['id'];
                        } else {
                                $errors['pswd'] = $pswd;
                        }
                } else {
                        $errors['pswd'] = "L'email est incorrect 2";
                }
                // $user = $database->findOne("SELECT * FROM users WHERE email = :email AND pswd = :pswd", $input
                // );
                // // $match = !!$user;
                // if ($user) {
                //         $errors['pswd'] = "L'email ou le mot de passe est incorrect";
                // }
        }

        // Renvoyer "ok" si aucune erreur n'a été trouvée
        if (empty($errors)) {
                echo json_encode("ok");
        } else {
                echo json_encode($errors);
        }
}