<?php

namespace Controllers;

use \Models\Horaires;
use \Models\Mail;
use JsonException;
// use \Models\Database;

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
        $errors = $success = $getMessage = [];
        
        if(array_key_exists('message', $_POST) && array_key_exists('email', $_POST) && array_key_exists('email', $_POST)){
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
                $success[] = "Votre message a bien été envoyé !";
            }
        }
        $template = "contact/index.phtml";
        include_once 'views/layout.phtml';
    }
}