<?php

namespace Controllers;

use \Models\Horaires;
use \Models\Mail;

class ContactController{

    public function displayContactPage(){
        $modelHoraires = new Horaires();
        $dates = $modelHoraires->getAllDates();

        $template = "contact/index.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayContactForm()
    {
        $template = "contact/mail.phtml";
        include_once 'views/layout.phtml';
    }

    public function submitMessage()
    {//vérifie et envoi le message du visitor sur l'adresse gmail du site
        $errors = $getMessage = [];
        $success = "";

        if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['message'])) {
            if (empty($_POST['email'])) {
                $errors[] = "Veuillez renseigner un email de contact";
            } elseif (!filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Veuillez renseigner un email valide";
                }

            if (empty($_POST['name'])) {
                $errors[] = "Veuillez indiquer votre nom";
            }

            if (empty($_POST['message'])) {
                $errors[] = "Veuillez écrire votre message";
            }

            if(count($errors) == 0){
                $getMessage = [
                    'email' => trim($_POST['email']),
                    'message' => trim($_POST['message']),
                    'name' => trim($_POST['name']),
                    'phone' => trim($_POST['phone'])
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
    public function displayMLPage(){

    $template = "contact/legal.phtml";
    include_once 'views/layout.phtml';
    }
}