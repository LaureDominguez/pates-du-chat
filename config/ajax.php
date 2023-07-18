<?php

// use Models\Users;

// require_once '../models/Users.php';
require_once '../models/Database.php';
// require_once 'config.php';


var_dump("j'en ai raz le cul");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $input = json_decode(file_get_contents('php://input'), true);
        $errors = [];
        $email = $input['email'];

        if (isset($input['pswd_confirm'])) { // check for register ///////////////////////
                var_dump('nouveau compte');

                // $model = new Models\Users();
                // $isItFree = $model->checkEmail($email);

                $isItFree = $database->findOne("SELECT id FROM users WHERE email = :email", $email);

                if (!empty($isItFree)) {
                        $errors[] = "Cet email est déjà utilisé";
                        return json_encode($errors);
                }

                //validation mot de passe
                $pswd = trim($input['pswd']);
                $numberMinimal = 8;

                if (strlen($pswd) < $numberMinimal) {
                        $errors[] = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        return json_encode($errors);
                }

                if (!preg_match('@[A-Z]@', $pswd)) {
                        $errors[] = "Le mot de passe doit inclure au moins une lettre majuscule";
                        return json_encode($errors);
                }

                if (!preg_match('@[a-z]@', $pswd)) {
                        $errors[] = "Le mot de passe doit inclure au moins une lettre minuscule";
                        return json_encode($errors);
                }

                if (!preg_match('@[0-9]@', $pswd)) {
                        $errors[] = "Le mot de passe doit inclure au moins un chiffre";
                        return json_encode($errors);
                }

                if (!preg_match('@[^\w]@', $pswd)) {
                        $errors[] = "Le mot de passe doit inclure au moins un caractère spécial";
                        return json_encode($errors);
                }

                $pswd_confirm = trim($input['pswd_confirm']);

                if (empty($errors) && ($pswd != $pswd_confirm)) {
                        $errors[] = "Les mots de passe ne correspondent pas";
                        return json_encode($errors);
                }

                // if (!empty($errors)) {
                //         echo json_encode($errors);
                // }

        } else { // check for login ////////////////////////////////
                var_dump('connexion');

                $result = $database->findOne("SELECT * FROM users WHERE email = :email AND pswd = :pswd", $input);
                echo json_encode(['match' => !!$result]);

                // $models = new Users();
                // $emailUsed = $model->checkEmail($email);
                // if (empty($emailUsed)) {
                //         $errors[] = "Email ou mot de passe inconnu 1";
                //         return json_encode($errors);
                // }

                // if (!empty($emailUsed) && password_verify($pswd, $userExist['pswd'])) {
                //         var_dump("c'est gagné");
                //         exit;
                // } else {
                //         $errors[] = "Email ou mot de passe inconnu 2";
                //         return json_encode($errors);
                // }

                // if (!empty($errors)) {
                //         echo json_encode($errors);
                // }
        }
}