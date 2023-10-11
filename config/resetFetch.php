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

        //envoi un mail avec le lien vers le formulaire qui renvoi vers resetPswd()
        $errors = [];
        $success = "";

        $token = bin2hex(random_bytes(16));
        $expiration = time() + 600; // le lien expire en 10 minutes

        // mdp oublié
        if (!empty($input['email'])){
                $email = $input['email'];
                // on verifie que l'email existe dans la db
                $userExist = $modelUser->checkEmail($email);

                if ($userExist) {
                        // si oui on lui envoie un mail avec un token qui expire dans 10min
                        $user = $modelUser->getUser($userExist['id']);
                        $newData = [
                                'id' => $user['id'],
                                'token' => $token,
                                'expiration' => $expiration
                        ];
                        //maj de user db
                        $modelUser->updateUser($newData);
                        //envoi du mail
                        $success = $modelMail->resetPswd($user);

                        if ($success) {
                                echo json_encode(["success" => true, "message" => "Un lien a été envoyé à l'adresse email enregistrée"]);
                        } else {
                                echo json_encode(["success" => false, "message" => "Une erreur s'est produite lors de l'envoi de l'email."]);
                        }
                } else {
                        echo json_encode(["success" => false, "message" => "Aucun utilisateur trouvé"]);
                }

        // changement de mdp depuis mon compte
        } elseif (isset($_SESSION['user'])) {
                $user = $modelUser->getUser($_SESSION['user']['id']);
                
                $newData = [
                                'id' => $user['id'],
                                'token' => $token,
                                'expiration' => $expiration
                        ];
                //maj de user db
                $modelUser->updateUser($newData);
                //envoi du mail
                $modelMail->resetPswd($user);

                echo json_encode(["success" => true, "message" => "Un lien de réinitialisation a été envoyé à l'adresse email enregistrée"]);
        } else {
                // Aucun cas valide, renvoyer une réponse JSON indiquant l'échec
                echo json_encode(["success" => false, "message" => "Aucun utilisateur trouvé"]);
        }

} else {
        echo json_encode(["success" => false]);
}