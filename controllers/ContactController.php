<?php

namespace Controllers;

use \Models\Horaires;
use \Models\Mail;

class ContactController{

    public function displayContactPage(){
        $modelHoraires = new Horaires();
        $dates = $modelHoraires->getAllDates();

        $description = "Où me trouver ?";
        $template = "contact/index.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayContactForm()
    {
        $description = "Contactez-moi !";
        $template = "contact/mail.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayMLPage()
    {
        $description = "Mentions légales";
        $template = "contact/legal.phtml";
        include_once 'views/layout.phtml';
    }

    public function submitMessage()
    {//vérifie et envoi le message du visitor sur l'adresse gmail du site
        $errors = $getMessage = [];
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $name = trim($_POST['name']);
            $message = trim($_POST['message']);
            $phone = trim($_POST['phone']);

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Veuillez renseigner une adresse e-mail valide.";
            }

            if (empty($name)) {
                $errors[] = "Veuillez indiquer votre nom.";
            }

            if (empty($message)) {
                $errors[] = "Veuillez écrire votre message.";
            }

            if(count($errors) == 0){
                $getMessage = [
                    'email' => $email,
                    'message' => $message,
                    'name' => $name,
                    'phone' => $phone,
                ];

                $modelMail = new Mail();
                $modelMail->sendContactMessage($getMessage);
                $success = "Votre message a bien été envoyé !";
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];
                
                header('Location: index.php?route=contactMail');
                exit();
            }
        }

        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];
        header('Location: ' . $_SESSION['visitor']['currentPage']);
        exit();
    }
}