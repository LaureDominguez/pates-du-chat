<?php

require_once './models/Database.php';
require_once './models/Users.php';
require_once './models/Mail.php';

// Function to update the image in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $modelUser = new Models\Users();
        $modelMail = new Models\Mail();
        // données reçues de fetch
        $input = json_decode(file_get_contents('php://input'), true);

        $email = $input['email'];

        //envoi un mail avec le lien vers le formulaire qui renvoi vers resetPswd()
        $errors = [];
        $success = "";

        // on verifie que l'email existe dans la db
        $userExist = $modelUser->checkEmail($email);


        if ($userExist) {
                // si oui on lui envoie un mail avec un token qui expire dans 10min
                $user = $modelUser->getUser($userExist['id']);
                $token = bin2hex(random_bytes(16));
                $expiration = time() + 600;


                $newData = [
                        'id' => $user['id'],
                        'token' => $token,
                        'expiration' => $expiration
                ];
                $modelUser->updateUser($newData);

                $modelMail->resetPswd($user);

                // $success = "L'image a bien été enregistrée !";
                // $_SESSION['visitor']['flash_message'] = [
                //         'success' => $success
                // ];
                echo json_encode(["success" => true]);
        } else {
                echo json_encode(["success" => false]);
        }
}