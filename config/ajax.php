<?php

// JS
// console.log('avant fetch');
//                 fetch("./config/ajax.php", {
//                     method: 'POST',
//                     body: JSON.stringify({
//                         nouvelleValeur: 'variable modifiée avec AJAX',
//                         headers: {
//                             'Content-Type': 'application/json'
//                         }
//                     })
                    
//                 })
//                     .then(response => response.text())
//                     .then(result => {
//                         console.log(result);
//                     })
//                     .catch(error => {
//                         console.log(error);
//                     })
//                 console.log('après fetch');



                // console.log('avant fetch');

                // const options = {
                //     method: 'POST',

                //     headers: {
                //         // Nous n'accepterons que le JSON en résultat.
                //         'Accept': 'application/json',
                //         // Dans le cas d'une requête contenant un body,
                //         // par exemple une POST ou PUT, on définit le format du body.
                //         'Content-Type': 'application/json',
                //         // Cas d'usage courant pour gérer l'authentification avec une API REST.
                //         // 'Authorization': 'Bearer ${token}'
                //     },

                //     body: JSON.stringify({
                //         title: 'Un post',
                //         content: 'Contenu de mon post'
                //     })
                // }


                // fetch("./config/ajax.php", options)
                //     .then(response => response.text())
                //     .then(result => {
                //         console.log(result);
                //     })
                //     .catch(error => {
                //         console.log(error);
                //     })
                // console.log('après fetch');
// end JS

$input = json_decode(file_get_contents('php://input'), true);

var_dump('resultat du ajax : ');
var_dump($input);
echo json_encode($_POST);
die;
// Récupère la nouvelle valeur envoyée depuis JavaScript
$nouvelleValeur = $_POST['nouvelleValeur'];
var_dump('variable nouvelleValeur :');
var_dump($nouvelleValeur);
// Modifie la variable $_SESSION avec la nouvelle valeur
$_SESSION['maVariable'] = $nouvelleValeur;

// if (isset($_SESSION['visitor']['msg']))
// $_SESSION['visitor']['msg'] = "";

// Réponse de retour (optionnelle)
echo 'Variable $_SESSION modifiée avec succès.';

var_dump($_SESSION);
