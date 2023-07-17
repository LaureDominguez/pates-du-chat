<?php

$input = json_decode(file_get_contents('php://input'), true);
$errors = [];
var_dump($input);
var_dump($errors);

$email = $input['email'];
// var_dump($email);

use Models\Users;

if(isset($input['pswd_confirm'])){ // check for register ///////////////////////
        var_dump('nouveau compte');

        $errors = $errors_email = $errors_pswd = $errors_verif = [];

        $model = new Users();
        $isItFree = $model->checkEmail($email);
        if (!empty($isItFree)){
                $errors[] = $errors_email[] = "Cet email est déjà utilisé";
        }

        //validation mot de passe
        $pswd = trim($input['pswd']);
        $numberMinimal = 8;

        switch ($pswd) {
                case strlen($pswd) < $numberMinimal:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        break;
                case preg_match('@[A-Z]@', $pswd) ?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins une lettre majuscule";
                        break;
                case preg_match('@[a-z]@', $pswd) ?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins une lettre minuscule";
                        break;
                case preg_match('@[0-9]@', $pswd) ?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins un chiffre";
                        break;
                case preg_match('@[^\w]@', $pswd) ?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins un caractère spécial";
                        break;
        }

        $pswd_confirm = trim($input['pswd_confirm']);
        if (empty($errors_pswd) && ($pswd != $pswd_confirm))
        $errors[] = $errors_verif[] = "Les mots de passe ne correspondent pas";

        echo json_encode($errors);

} else { // check for login ////////////////////////////////
        var_dump('connexion');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email ou mot de passe inconnu 1";
                echo json_encode($errors);
                exit;
        } else {
                $model = new Users();
                $emailUsed = $model->checkEmail($email);
                if (empty($emailUsed)) {
                        $errors[] = "Email ou mot de passe inconnu 2";
                        echo json_encode($errors);
                        exit;
                }
                if (!empty($emailUsed)) {
                        $model = new Users();
                        $userExist = $model->getUser($emailUsed['id']);

                        // Validation du mot de passe
                        $pswd = trim($input['pswd']);
                        // Si pas d'erreur, alors créer la session utilisateur. Sinon à la fin
                        if (count($errors) == 0) {
                                if (password_verify($pswd, $userExist['pswd'])) {
                                        var_dump("c'est gagné");
                                        die;
                                } else {
                                        $errors[] = "Email ou mot de passe inconnu 3";
                                        echo json_encode($errors);
                                        var_dump('chiant3');
                                        exit;
                                }
                        } else {
                                // Sinon on affiche les erreurs
                                echo json_encode($errors);
                                var_dump('chiant');
                                exit;
                        }
                }
        }
}
