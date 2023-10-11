<?php

namespace Models;

class Mail
{
    private $base_url;
    private $image_url;
    private $font_url;

    public function __construct()
    {
        $this->base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $this->image_url = $this->base_url . "/public/img/site/";
        $this->font_url = $this->base_url . "/public/font/";
    }

    private function sendEmail($destinataire, $subject, $message)
    {
        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From: "Les Pâtes du Chat" <dominguezlaure@gmail.com>' . "\r\n";
        $header .= "X-Priority: 1\r\n";
        $header .= 'Content-Type: text/html; charset="utf-8"' . "\r\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        if (mail($destinataire, $subject, $message, $header)) {
            return true;
        } else {
            return false;
        }
    }

    public function sendContactMessage($contact)
    {
        $destinataire = 'dominguezlaure@gmail.com';
        $subject = 'Nouveau message de ' . $contact['name'];

        $emailContent = '
            <h1>Vous avez reçu un nouveau message de : <br> ' . $contact['name'] . '</h1>
            <h2>Email : ' . $contact['email'] . '</h2>
            <h2>Téléphone : ' . $contact['phone'] . '</h2>
            <h2>Message :</h2>
            <p>"</p>
            <p>' . $contact['message'] . '</p>
            <p>"</p>
        ';

        $message = $this->generateEmailMessage($contact, $emailContent);

        $this->sendEmail($destinataire, $subject, $message);
    }

    public function welcomeMessage($newUser)
    {
        $destinataire = $newUser['email'];
        $subject = 'Bienvenue chez Les Pâtes du Chat !';

        $emailContent = '
            <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
            <p>Nous sommes ravis de vous accueillir chez Les Pâtes du Chat ! <br>Merci de nous avoir rejoint.</p>
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
        ';

        $message = $this->generateEmailMessage($newUser, $emailContent);

        $this->sendEmail($destinataire, $subject, $message);
    }

    public function VerifMessage($newUser)
    {
        $destinataire = $newUser['email'];
        $subject = 'Vérification de votre adresse e-mail';

        $emailContent = '
            <h1>Cher(e) ' . (isset($newUser['name']) ? $newUser['name'] : $newUser['email']) .  ',</h1>
            <p>Nous vous remercions de vous être inscrit(e) chez Les Pâtes du Chat ! <br>Avant de pouvoir profiter pleinement de tous nos services, nous devons vérifier votre adresse e-mail.</p>
            <p>Pour valider votre compte, veuillez cliquer sur le lien de vérification ci-dessous :</p>
            <div class="link">
                <p>
                    <a href="https://laure-web.fr/index.php?route=validate&token=' . $newUser['token'] . '&email=' . urlencode($newUser['email']) . '">Lien de validation</a>
                </p>
            </div>
            <p>Ce lien est unique et ne peut être utilisé qu\'une seule fois pour confirmer votre adresse e-mail. Assurez-vous de ne pas partager ce lien avec d\'autres personnes.</p>
            <p>Si vous ne parvenez pas à cliquer sur le lien, vous pouvez également copier et coller l\'URL dans la barre d\'adresse de votre navigateur.</p>
            <p>Une fois votre adresse e-mail confirmée, vous aurez un accès complet à Les Pâtes du Chat et à toutes ses fonctionnalités passionnantes.</p>
            <p>Si vous n\'avez pas créé de compte sur Les Pâtes du Chat, veuillez ignorer cet e-mail.</p>
            <p>Nous sommes ravis de vous avoir parmi nous et sommes impatients de vous offrir une expérience exceptionnelle sur notre plateforme. Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail">Page de Contact</a>.</p>
            <p>Merci de nous faire confiance !</p>
        ';

        $message = $this->generateEmailMessage($newUser, $emailContent);

        $this->sendEmail($destinataire, $subject, $message);
    }

    public function resetPswd($user)
    {
        $destinataire = $user['email'];
        $subject = 'Réinitialisation de votre mot de passe';

        $emailContent = '
            <h1>Cher(e) ' . (isset($user['name']) ? $user['name'] : $user['email']) .  ',</h1>
                        <p>Vous recevez cet e-mail car vous avez demandé une réinitialisation de votre mot de passe sur Les Pâtes du Chat. <br>Pour réinitialiser votre mot de passe, veuillez suivre les étapes ci-dessous :</p>
                        <ol>
                            <li>
                                <p>Cliquez sur le lien ci-dessous pour accéder à la page de réinitialisation de mot de passe :</p>
                                <div class="link">
                                    <p>
                                        <a href="https://laure-web.fr/index.php?route=resetPswd&token=' . $user['token'] . '&email=' . urlencode($user['email']) . '">Lien de réinitialisation du mot de passe</a>
                                    </p>
                                </div>
                            </li>
                            <li>
                                Vous serez redirigé(e) vers une page où vous pourrez créer un nouveau mot de passe sécurisé.
                            </li>
                        </ol>
                        <p><span class="souligne">Note :</span> Ce lien de réinitialisation du mot de passe expire dans <span class="souligne">10 minutes</span>. Si vous ne réinitialisez pas votre mot de passe dans ce délai, vous devrez effectuer une nouvelle demande.</p>
                        <p>Si vous n\'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité. Votre mot de passe actuel restera inchangé.</p>
                        <p>Nous vous remercions d\'utiliser nos services. Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter via notre <a href="https://laure-web.fr/index.php?route=contactMail">Page de Contact</a>.</p>
                        <p>Merci de nous faire confiance !</p>
        ';

        $message = $this->generateEmailMessage($user, $emailContent);

        $success = $this->sendEmail($destinataire, $subject, $message);

        if ($success){
            return true;
        } else {
            return false;
        }
    }

    private function generateEmailMessage($data, $emailContent)
    {
        $name = isset($data['name']) ? $data['name'] : $data['email'];

        return <<<HTML
            <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            margin: 0;
                            padding: 0;
                        }
                        h1 {
                            font-family: Pacifico, cursive;
                            font-size: 24px;
                            color: #004f12;
                        }
                        h2{
                            font-size: 18px;
                        }
                        .souligne{
                            text-decoration: underline;
                        }

                        .mail {
                            background-color: #fff;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                            font-size: 16px;
                        }
                        .mail ol {
                            font-weight: bold;
                            color: green;
                        }

                        .link {
                            border: solid 1px;
                            border-radius: 25px;
                            margin-bottom : 1rem;
                        }
                        .link a{
                            padding: 0 2rem;
                        }

                        .social p{
                            font-style: italic;
                            color: #f28f18;
                        }
                        .social div{
                            text-align: center;
                        }
                        .social img{
                            height: 2rem;
                            margin: 1rem 0;
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
                            <img src="{$this->image_url}/Logo-Arnaud.png" alt="Logo" class="logo"/>
                        </a>

                        $emailContent

                        <p>Cordialement,</p>
                        <p>L'équipe des Pâtes du Chat 😺</p>

                        <div class="social">
                            <p>P.S. N'oubliez pas de nous suivre sur les réseaux sociaux pour rester informé(e) de nos dernières nouvelles et mises à jour :<p>
                            <div>
                                <a href="https://www.facebook.com/profile.php?id=100094325392125">
                                    <img src="{$this->image_url}/facebook_logo.png" alt="facebook" class="social"/>
                                </a>
                                <img src="{$this->image_url}/twitter_logo.png" alt="x-twitter" class="social"/>
                                <img src="{$this->image_url}/instagram_logo.png" alt="instagram" class="social"/>
                            </div>
                        </div>
                    </div>
                    <div class="mention">
                        <p>Veuillez ne pas répondre à ce message, car nous ne pouvons pas envoyer de réponse à partir de cette adresse e-mail.<p>
                    </div>
                </body>
            </html>
HTML;
    }
}
