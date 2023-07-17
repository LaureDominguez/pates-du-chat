<?php

$input = json_decode(file_get_contents('php://input'), true);
$errors = [];
// var_dump($input);
// var_dump($errors);

$email = $input['email'];
// var_dump($email);

use Models\Users;

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

                // Stockage du mdp pour vérification
                $pswd = trim($input['pswd']);
                // Si pas d'erreur, alors créer la session utilisateur. Sinon à la fin
                if (count($errors) == 0) {
                        if (password_verify($pswd, $userExist['pswd'])) {
                                var_dump("c'est gagné");
                                die;
                                // header('Location: index.php?route=home');
                                // exit;
                        } else {
                                $errors[] = "Email ou mot de passe inconnu 3";
                                echo json_encode($errors);
                                var_dump('chiant1');
                                exit;
                        }
                } else {
                        // Sinon on affiche les erreurs
                        echo json_encode($errors);
                        var_dump('chiant1');
                        exit;
                }
        }
}

// header('Location: ' . $_SESSION['visitor']['currentPage']);
// exit;
