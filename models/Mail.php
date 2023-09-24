<?php 

namespace Models;

class Mail {
    public function sendContactMessage($contact)
    {        
        $destinataire = 'dominguezlaure@gmail.com';
        $subject = 'Nouveau message de ' . $contact['name'];

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From: "Les Pâtes du Chat" <dominguezlaure@gmail.com>' . "\r\n"; 
        // L'adresse email de l'expéditeur peut être remplacé par une constante dans le fichier "config.php"
        // $header .= "Cc: ......@hotmail.com\n";
        $header .= "X-Priority: 1\r\n";
        $header .= 'Content-Type: text/html; charset="uft-8"' . "\r\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $image_url = $base_url . "/public/img/site/Logo-Arnaud.png";

        $message = '
            <html>
                <head>
                    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            margin: 0;
                            padding: 0;
                        }
                        .mail {
                            background-color: #fff;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                        }
                        h1 {
                            font-family: Pacifico, cursive;
                            font-size: 1.5rem;
                            color: #004f12;
                        }
                        h2{
                            font-size: 1rem;
                        }
                        .mail p {
                            font-size: 1rem;
                        }
                        .mention p{
                            font-size: 0.8rem;
                            line-height: 1rem;
                            color: #666;
                            text-align: center;
                            margin: auto;
                            max-width: 600px;
                        }
                        img{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . '" alt="Logo"/>
                        </a>
                        <h1>Vous avez reçu un nouveau message de : <br> '. $contact['name'] . '</h1>
                        <h2>Email : '. $contact['email'] . '</h2>
                        <h2>Téléphone : '. $contact['phone'] . '</h2>
                        <h2>Message :</h2>
                        <p>"</p>
                        <p>'. $contact['message'] . '</p>
                        <p>"</p>
                    </div>
                    <div class="mention">
                        <p>Veuillez ne pas répondre à ce message, car nous ne pouvons pas envoyer de réponse à partir de cette adresse e-mail.<p>
                    </div>
                </body>
            </html>';

        if (mail($destinataire, $subject, $message, $header)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'email.";
        }
    }

    public function welcomeMessage($newUser)
    {
        $destinataire = $newUser['email'];
        $subject = 'Bienvenue sur Les Pâtes du Chat !';

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From: "Les Pâtes du Chat" <dominguezlaure@gmail.com>' . "\r\n";
        // L'adresse email de l'expéditeur peut être remplacé par une constante dans le fichier "config.php"
        // $header .= "Cc: ......@hotmail.com\n";
        $header .= "X-Priority: 1\r\n";
        $header .= 'Content-Type: text/html; charset="uft-8"' . "\r\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $image_url = $base_url . "/public/img/site/Logo-Arnaud.png";

        $message = '
            <html>
                <head>
                    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            margin: 0;
                            padding: 0;
                        }
                        .mail {
                            background-color: #fff;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                        }
                        h1 {
                            font-family: Pacifico, cursive;
                            font-size: 1.5rem;
                            color: #004f12;
                        }
                        h2{
                            font-size: 1rem;
                        }
                        .mail p {
                            font-size: 1rem;
                            text-align: justify;
                        }
                        .mention p{
                            font-size: 0.8rem;
                            line-height: 1rem;
                            color: #666;
                            text-align: center;
                            margin: auto;
                            max-width: 600px;
                        }
                        img{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . '" alt="Logo"/>
                        </a>
                        <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
                        <p>Nous sommes ravis de vous accueillir sur Les Pâtes du Chat ! <br>Merci de nous avoir rejoint.</p>
                        <p>Votre adhésion a été créée avec succès, et vous êtes maintenant membre de notre communauté. Vous pouvez dès à présent profiter des avantages de votre compte.</p>
                        <p>Voici quelques informations importantes pour commencer :</p>
                        <div>
                            <p>Votre Nom d\'Utilisateur : ' . $newUser['name'] . '</p>
                            <p>Votre Adresse E-mail : ' . $newUser['email'] . '</p>
                        </div>

                        <h2>Que pouvez-vous faire maintenant ?</h2>
                        <ol>
                            <li>
                                Connectez-vous à votre compte : Utilisez votre nom d\'utilisateur et votre mot de passe pour accéder à votre compte sur [Lien de Connexion].
                            </li>
                            <li>
                                Personnalisez votre profil : Ajoutez une photo de profil et complétez vos informations personnelles pour rendre votre profil unique.
                            </li>
                            <li>
                                Explorez notre contenu : Parcourez notre site web pour découvrir nos fonctionnalités, articles, produits et services.
                            </li>
                            <li>
                                Contactez notre équipe d\'assistance : Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via [Adresse E-mail de l\'Assistance] ou notre [Page de Contact].
                            </li>
                        </ol>
                        <p>Nous tenons à vous remercier de nous avoir rejoint, et nous sommes déterminés à vous fournir la meilleure expérience possible sur notre plateforme. Restez à l\'écoute pour les dernières mises à jour, offres spéciales et bien plus encore !</p>
                        <p>Bienvenue encore une fois, ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ' ! <br>Nous sommes impatients de vous voir profiter de tout ce que Les Pâtes du Chat a à offrir.</p>
                        <p>Cordialement,</p>
                        <p>L\'équipe des Pâtes du Chat 😺</p>

                        <p>P.S. N\'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                        <ul>
                            <li>[Lien vers la Page Facebook]</li>
                            <li>[Lien vers le Compte Twitter]</li>
                            <li>[Lien vers le Compte Instagram]</li>
                        </ul>
                    </div>
                    <div class="mention">
                        <p>Veuillez ne pas répondre à ce message, car nous ne pouvons pas envoyer de réponse à partir de cette adresse e-mail.<p>
                    </div>
                </body>
            </html>';

        if (mail($destinataire, $subject, $message, $header)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'email.";
        }
    }

    public function VerifMessage($newUser)
    {
        $destinataire = $newUser['email'];
        $subject = 'Vérification de votre adresse e-mail';

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From: "Les Pâtes du Chat" <dominguezlaure@gmail.com>' . "\r\n";
        // L'adresse email de l'expéditeur peut être remplacé par une constante dans le fichier "config.php"
        // $header .= "Cc: ......@hotmail.com\n";
        $header .= "X-Priority: 1\r\n";
        $header .= 'Content-Type: text/html; charset="uft-8"' . "\r\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $image_url = $base_url . "/public/img/site/Logo-Arnaud.png";

        $message = '
            <html>
                <head>
                    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            margin: 0;
                            padding: 0;
                        }
                        .mail {
                            background-color: #fff;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                        }
                        h1 {
                            font-family: Pacifico, cursive;
                            font-size: 1.5rem;
                            color: #004f12;
                        }
                        h2{
                            font-size: 1rem;
                        }
                        .link{
                            text-align: center;
                        }
                        .mail p {
                            font-size: 1rem;
                            text-align: justify;
                        }
                        .mention p{
                            font-size: 0.8rem;
                            line-height: 1rem;
                            color: #666;
                            text-align: center;
                            margin: auto;
                            max-width: 600px;
                        }
                        img{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . '" alt="Logo"/>
                        </a>
                        <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
                        <p>Nous vous remercions de vous être inscrit(e) sur Les Pâtes du Chat ! <br>Avant de pouvoir profiter pleinement de tous nos services, nous devons vérifier votre adresse e-mail.</p>
                        <p>Pour valider votre compte, veuillez cliquer sur le lien de vérification ci-dessous :</p>
                        <div class="link">
                            <a href="https://laure-web.fr/index.php?route=validate?token=' . $newUser['token'] . '&email=' . urlencode($newUser['email']) . '">Lien de validation</a>
                        </div>
                        <p>Ce lien est unique et ne peut être utilisé qu\'une seule fois pour confirmer votre adresse e-mail. Assurez-vous de ne pas partager ce lien avec d\'autres personnes.</p>
                        <p>Si vous ne parvenez pas à cliquer sur le lien, vous pouvez également copier et coller l\'URL dans la barre d\'adresse de votre navigateur.</p>
                        <p>Une fois votre adresse e-mail confirmée, vous aurez un accès complet à Les Pâtes du Chat et à toutes ses fonctionnalités passionnantes.</p>
                        <p>Si vous n\'avez pas créé de compte sur Les Pâtes du Chat, veuillez ignorer cet e-mail.</p>
                        <p>Nous sommes ravis de vous avoir parmi nous et sommes impatients de vous offrir une expérience exceptionnelle sur notre plateforme. Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail>Page de Contact</a>.</p>
                        <p>Merci de nous faire confiance !</p>
                        
                        <p>Cordialement,</p>
                        <p>L\'équipe des Pâtes du Chat 😺</p>

                        <p>P.S. N\'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                        <ul>
                            <li>[Lien vers la Page Facebook]</li>
                            <li>[Lien vers le Compte Twitter]</li>
                            <li>[Lien vers le Compte Instagram]</li>
                        </ul>
                    </div>
                    <div class="mention">
                        <p>Veuillez ne pas répondre à ce message, car nous ne pouvons pas envoyer de réponse à partir de cette adresse e-mail.<p>
                    </div>
                </body>
            </html>';

        if (mail($destinataire, $subject, $message, $header)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'email.";
        }
    }
}