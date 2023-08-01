<?php 

namespace Models;

class Mail {
    public function sendContactMessage($contact)
    {
        /*
            $path           = 'Config/Icons/Cars.png'; // chemin vers le fichier
            $fp             = fopen($path, 'rb');
            $content        = fread($fp, filesize($path));
            fclose($fp);
            $content_encode = chunk_split(base64_encode($content));
        */
        
        $destinataire = 'dominguezlaure@gmail.com';
        $subject = 'Nouveau message de ' . $contact['name'];

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From:"Les Pâtes du Chat"<dominguezlaure@gmail.com>' . "\n"; // L'adresse email de l'expéditeur peut être remplacé par une constante dans le fichier "config.php"
        // $header .= "Cc: ......@hotmail.com\n";
        $header .= "X-Priority: 1\n";
        $header .= 'Content-Type: text/html; charset="uft-8"' . "\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $message = '
            <html>
                <body>
                    <div align="center">
                        <img src="./public/img/site.Logo texte.png"/>
                        <br />
                        Vous avez reçu un nouveau message de : '. $contact['name'] . ' 
                        <br />
                        Mail : '. $contact['email'] . ' 
                        <br />
                        Tel : '. $contact['phone'] . '
                        <br />
                        Message :
                        <br />
                        "
                        <br />
                        '. $contact['message'] . '
                        <br />
                        "
                        <br />
                        <img src="http://www.primfx.com/mailing/separation.png"/>
                    </div>
                </body>
            </html>';
        /*
            $message .= "Content-Disposition: attachment; filename=\"Cars.png\"\n\n";
            $message .= $content_encode . "\n";
            $message .= "\n\n";
        */

        if (mail($destinataire, $subject, $message, $header)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'email.";
        }
    }
}