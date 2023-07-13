<?php
// session_start();

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
