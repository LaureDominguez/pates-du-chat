<?php

require_once '../models/Database.php';
require_once '../models/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $users = new Models\Users();
        $input = json_decode(file_get_contents('php://input'), true);
        $errors = [];
        $email = $input['email'];

        $newUser = [
                trim($input['email']),
                password_hash(trim($input['pswd']), PASSWORD_DEFAULT),
        ];

        if (isset($input['pswd_confirm'])) { 

                ////////////////// check for register ///////////////////////
                $checkEmail = $users->checkEmail("SELECT id FROM users WHERE email = :email");

                if ($checkEmail === true) {
                        $errors['mail'] = "Cet email est déjà utilisé";
                }

        } else {
                /////////////////// check for login ////////////////////////////////

                // Récupérer l'utilisateur à partir de son email
                $user = $database->findOne("SELECT * FROM users WHERE email = :email", ['email' => $input['email']]);
                if ($user) {
                        // Vérifier si le mot de passe fourni correspond au hachage stocké dans la base de données
                        $hashedPassword = $user['pswd'];
                        $pswd = trim($input['pswd']);
                        if (password_verify($pswd, $hashedPassword)) {
                                // Mot de passe correct
                                // Vous pouvez effectuer d'autres actions, par exemple, créer une session utilisateur ici
                                // Par exemple :
                                // session_start();
                                // $_SESSION['user_id'] = $user['id'];
                        } else {
                                $errors['pswd'] = "L'email ou le mot de passe est incorrect";
                        }
                } else {
                        $errors['pswd'] = "L'email ou le mot de passe est incorrect";
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