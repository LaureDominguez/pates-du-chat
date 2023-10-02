<?php 

namespace Models;

class Mail {
    ////////////// Contact
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
        $image_url = $base_url . "/public/img/site/";
        $font_url = $base_url . "/public/font/";

        $message = '
            <html>
                <head>
                    <style>
                        @font-face {
                            font-family: "Pacifico";
                            src: url("' . $font_url . 'Pacifico-Regular.ttf") format("truetype");
                        }
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
                        .logo{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . 'Logo-Arnaud.png" alt="Logo" class="logo"/>
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

    //////////////////// Welcome

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
        $image_url = $base_url . "/public/img/site/";
        $font_url = $base_url . "/public/font/";

        $message = '
            <html>
                <head>
                    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
                    <style>
                        @font-face {
                            font-family: "Pacifico";
                            src: url("' . $font_url . 'Pacifico-Regular.ttf") format("truetype");
                        }
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
                        .logo{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . 'Logo-Arnaud.png" alt="Logo" class="logo"/>
                        </a>
                        <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
                        <p>Nous sommes ravis de vous accueillir sur Les Pâtes du Chat ! <br>Merci de nous avoir rejoint.</p>
                        <p>Votre compte a été créé avec succès, et vous êtes maintenant membre de notre communauté. Vous pouvez dès à présent profiter des avantages de votre compte.</p>
                        <p>Voici quelques informations importantes pour commencer :</p>
                        <div>
                            <p>Votre Adresse E-mail : ' . $newUser['email'] . '</p>
                        </div>

                        <h2>Que pouvez-vous faire maintenant ?</h2>
                        <ol>
                            <li>
                                Connectez-vous à votre compte : Utilisez votre nom d\'utilisateur et votre mot de passe pour accéder à votre compte sur <a href="https://laure-web.fr/">Les Pâtes du Chat</a>.
                            </li>
                            <li>
                                Personnalisez votre profil : Ajoutez une photo de profil et complétez vos informations personnelles pour rendre votre profil unique.
                            </li>
                            <li>
                                Explorez notre contenu : Parcourez notre site web pour découvrir nos fonctionnalités, articles, produits et services.
                            </li>
                            <li>
                                Contactez notre équipe d\'assistance : Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail">Page de Contact</a>.
                            </li>
                        </ol>
                        <p>Nous tenons à vous remercier de nous avoir rejoint, et nous sommes déterminés à vous fournir la meilleure expérience possible sur notre plateforme. Restez à l\'écoute pour les dernières mises à jour, offres spéciales et bien plus encore !</p>
                        <p>Bienvenue encore une fois, ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ' ! <br>Nous sommes impatients de vous voir profiter de tout ce que Les Pâtes du Chat a à offrir.</p>
                        <p>Cordialement,</p>
                        <p>L\'équipe des Pâtes du Chat 😺</p>

                        <p>P.S. N\'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/profile.php?id=100094325392125">
                                    <img src="' . $image_url . 'square-facebook.svg" alt="facebook" class="social"/>
                                </a>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-x-twitter.svg" alt="x-twitter" class="social"/>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-instagram.svg" alt="instagram" class="social"/>
                            </li>
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

    /////////////////////////////// Verif

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
        $image_url = $base_url . "/public/img/site/";
        $font_url = $base_url . "/public/font/";

        $message = '
            <html>
                <head>
                    <style>
                        @font-face {
                            font-family: "Pacifico";
                            src: url("' . $font_url . 'Pacifico-Regular.ttf") format("truetype");
                        }
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
                        .logo{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . 'Logo-Arnaud.png" alt="Logo" class="logo"/>
                        </a>
                        <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
                        <p>Nous vous remercions de vous être inscrit(e) sur Les Pâtes du Chat ! <br>Avant de pouvoir profiter pleinement de tous nos services, nous devons vérifier votre adresse e-mail.</p>
                        <p>Pour valider votre compte, veuillez cliquer sur le lien de vérification ci-dessous :</p>
                        <div class="link">
                            <a href="https://laure-web.fr/index.php?route=validate&token=' . $newUser['token'] . '&email=' . urlencode($newUser['email']) . '">Lien de validation</a>
                        </div>
                        <p>Ce lien est unique et ne peut être utilisé qu\'une seule fois pour confirmer votre adresse e-mail. Assurez-vous de ne pas partager ce lien avec d\'autres personnes.</p>
                        <p>Si vous ne parvenez pas à cliquer sur le lien, vous pouvez également copier et coller l\'URL dans la barre d\'adresse de votre navigateur.</p>
                        <p>Une fois votre adresse e-mail confirmée, vous aurez un accès complet à Les Pâtes du Chat et à toutes ses fonctionnalités passionnantes.</p>
                        <p>Si vous n\'avez pas créé de compte sur Les Pâtes du Chat, veuillez ignorer cet e-mail.</p>
                        <p>Nous sommes ravis de vous avoir parmi nous et sommes impatients de vous offrir une expérience exceptionnelle sur notre plateforme. Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail">Page de Contact</a>.</p>
                        <p>Merci de nous faire confiance !</p>
                        
                        <p>Cordialement,</p>
                        <p>L\'équipe des Pâtes du Chat 😺</p>

                        <p>P.S. N\'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/profile.php?id=100094325392125">
                                    <img src="' . $image_url . 'square-facebook.svg" alt="facebook" class="social"/>
                                </a>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-x-twitter.svg" alt="x-twitter" class="social"/>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-instagram.svg" alt="instagram" class="social"/>
                            </li>
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


    /////////////////////////////// Reset password

    public function resetPswd($user)
    {
        $destinataire = $user['email'];
        $subject = 'Réinitialisation de votre mot de passe';

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From: "Les Pâtes du Chat" <dominguezlaure@gmail.com>' . "\r\n";
        // L'adresse email de l'expéditeur peut être remplacé par une constante dans le fichier "config.php"
        // $header .= "Cc: ......@hotmail.com\n";
        $header .= "X-Priority: 1\r\n";
        $header .= 'Content-Type: text/html; charset="uft-8"' . "\r\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $image_url = $base_url . "/public/img/site/";
        $font_url = $base_url . "/public/font/";

        $message = '
            <html>
                <head>
                    <style>
                        @font-face {
                            font-family: "Pacifico";
                            src: url("' . $font_url . 'Pacifico-Regular.ttf") format("truetype");
                        }
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
                        .logo{
                            height: 9rem;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail">
                        <a href="https://laure-web.fr/">
                            <img src="' . $image_url . 'Logo-Arnaud.png" alt="Logo" class="logo"/>
                        </a>
                        <h1>Cher(e) ' . (isset($user['name']) ? $user['name'] : $user['email']) .  ',</h1>
                        <p>Vous recevez cet e-mail car vous avez demandé une réinitialisation de votre mot de passe sur Les Pâtes du Chat. <br>Pour réinitialiser votre mot de passe, veuillez suivre les étapes ci-dessous :</p>
                        <ol>
                            <li>
                                <p>Cliquez sur le lien ci-dessous pour accéder à la page de réinitialisation de mot de passe :</p>
                                <div class="link">
                                    <a href="https://laure-web.fr/index.php?route=resetPswd&token=' . $user['token'] . '&email=' . urlencode($user['email']) . '">Lien de réinitialisation du mot de passe</a>
                                </div>
                            </li>
                            <li>
                                Vous serez redirigé(e) vers une page où vous pourrez créer un nouveau mot de passe sécurisé.
                            </li>
                        </ol>
                        <p>Note : Ce lien de réinitialisation du mot de passe expire dans 10 minutes. Si vous ne réinitialisez pas votre mot de passe dans ce délai, vous devrez effectuer une nouvelle demande.</p>
                        <p>Si vous n\'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité. Votre mot de passe actuel restera inchangé.</p>
                        <p>Nous vous remercions d\utiliser nos services. Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail">Page de Contact</a>.</p>
                        <p>Merci de nous faire confiance !</p>
                        
                        <p>Cordialement,</p>
                        <p>L\'équipe des Pâtes du Chat 😺</p>

                        <p>P.S. N\'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/profile.php?id=100094325392125">
                                    <img src="' . $image_url . 'square-facebook.svg" alt="facebook" class="social"/>
                                </a>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-x-twitter.svg" alt="x-twitter" class="social"/>
                            </li>
                            <li>
                                <img src="' . $image_url . 'square-instagram.svg" alt="instagram" class="social"/>
                            </li>
                        </ul>
                    </div>
                    <div class="mention">
                        <p>Veuillez ne pas répondre à ce message, car nous ne pouvons pas envoyer de réponse à partir de cette adresse e-mail.<p>
                    </div>
                </body>
            </html>';

        if (mail($destinataire,
            $subject,
            $message,
            $header
        )) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'email.";
        }
    }
}