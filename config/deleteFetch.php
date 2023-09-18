<?php

require_once './models/Database.php';
require_once './models/Gallery.php';
require_once './models/Products.php';

// Function to delete image from database and stockage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();

        // Récupérez l'ID du produit et de l'image à supprimer
        $productID = $_POST['product_id'];
        $imageID = $_POST['image_id'];

        // Supprimer l'image de la table "images"
        $galleryModel = new Models\Gallery();
        $galleryModel->deleteImage($imageID); // Supprimez l'image de la table "images"

        // Supprimer l'association entre le produit et l'image dans la table "products"
        $productsModel = new Models\Products();
        $productsModel->updateProduct(['img' => null, 'id' => $productID]); // Mettez à jour la colonne "img" avec NULL

        // Répondez avec un JSON pour indiquer le succès
        echo json_encode(['success' => true]);
} else {
        // Répondez avec une erreur si la requête n'est pas de type POST
        echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}