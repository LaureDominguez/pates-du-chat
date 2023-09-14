<?php

require_once './models/Database.php';
require_once './models/Gallery.php';
require_once './models/Products.php';

// Function to delete image from database and stockage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();

        // Récupérez l'ID du produit et de l'image à supprimer
        $productID = $_POST['product_id']; // Vous devez sécuriser cette valeur avant de l'utiliser.
        $imageID = $_POST['image_id']; // Vous devez sécuriser cette valeur avant de l'utiliser.

        // Supprimer l'association entre le produit et l'image dans la table "products"
        $productsModel = new Models\Products();
        $productsModel->updateProduct(['img' => null, 'id' => $productID]); // Mettez à jour la colonne "img" avec NULL

        // Supprimer l'image de la table "images" (assurez-vous que l'image n'est pas utilisée ailleurs avant de la supprimer)
        $galleryModel = new Models\Gallery();
        $galleryModel->deleteOne('images', $imageID); // Supprimez l'image de la table "images"

        // Répondez avec un JSON pour indiquer le succès
        echo json_encode(['success' => true]);
} else {
        // Répondez avec une erreur si la requête n'est pas de type POST
        echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}