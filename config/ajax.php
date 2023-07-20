<?php

require_once '../models/Database.php';
require_once '../models/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $users = new Models\Users();
        $input = json_decode(file_get_contents('php://input'), true);
        $errors = [];
        $email = $input['email'];

        if (isset($input['pswd_confirm'])) { 

                ////////////////// check for register ///////////////////////
                $checkEmail = $users->checkEmail("SELECT id FROM users WHERE email = :email");

                if ($checkEmail === true) {
                        $errors['mail'] = "Cet email est déjà utilisé";
                        // echo json_encode($errors);
                        // exit;
                } else {
                        //validation mot de passe
                        $pswd = trim($input['pswd']);
                        $numberMinimal = 8;
                        // var_dump('check 2');

                        if (strlen($pswd) < $numberMinimal) {
                                $errors['pswd'] = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        } else if (!preg_match('@[A-Z]@', $pswd)) {
                                $errors['pswd'] = "Le mot de passe doit inclure au moins une lettre majuscule";
                        } else if (!preg_match('@[a-z]@', $pswd)) {
                                $errors['pswd'] = "Le mot de passe doit inclure au moins une lettre minuscule";
                        } else if (!preg_match('@[0-9]@', $pswd)) {
                                $errors['pswd'] = "Le mot de passe doit inclure au moins un chiffre";
                        } else if (!preg_match('@[^\w]@', $pswd)) {
                                $errors['pswd'] = "Le mot de passe doit inclure au moins un caractère spécial";
                        } else if ($pswd !== trim($input['pswd_confirm'])) {
                                $errors['pswd'] = "Les mots de passe ne correspondent pas";
                        }

                        // switch (true) {
                        //         case strlen($pswd) < $numberMinimal:
                        //                 $error = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        //                 break;
                        //         case !preg_match('@[A-Z]@', $pswd):
                        //                 $error = "Le mot de passe doit inclure au moins une lettre majuscule";
                        //                 break;
                        //         case !preg_match('@[a-z]@', $pswd):
                        //                 $error = "Le mot de passe doit inclure au moins une lettre minuscule";
                        //                 break;
                        //         case !preg_match('@[0-9]@', $pswd):
                        //                 $error = "Le mot de passe doit inclure au moins un chiffre";
                        //                 break;
                        //         case !preg_match('@[^\w]@', $pswd):
                        //                 $error = "Le mot de passe doit inclure au moins un caractère spécial";
                        //                 break;
                        //         case $pswd !== trim($input['pswd_confirm']):
                        //                 $error = "Les mots de passe ne correspondent pas";
                        //                 break;
                        // }

                        // if ($error !== null) {
                        //         echo json_encode(['pswd' => $error]);
                        // } else {
                        //         // Aucune erreur, renvoyer une réponse 'OK'
                        //         echo json_encode(['OK']);
                        // }
                }

        } else {
                /////////////////// check for login ////////////////////////////////

                $result = $database->findOne("SELECT * FROM users WHERE email = :email AND pswd = :pswd", $input
                );
                $match = !!$result;
                if (!$match) {
                        $errors['pswd'] = "L'email ou le mot de passe est incorrect";
                }
        }

        echo json_encode($errors);
}