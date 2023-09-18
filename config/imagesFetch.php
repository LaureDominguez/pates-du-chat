<?php

require_once './models/Database.php';
require_once './models/Gallery.php';
require_once './models/Products.php';

// Function to update the image in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_FILES['img'])) {
        $database = new Models\Database();
        $modelGalery = new Models\Gallery();
        $modelProduct = new Models\Products();

        //la destination de l'image à uploader
        $uploadDir = "./public/img/produits/";
        $imgName = str_replace(' ', '-', $_FILES['img']['name']);
        $imagePath = $uploadDir . basename($imgName);



        //les données de l'image
        $imgFile = $_FILES['img']['tmp_name'];

        if ($_POST['productId']) {
                $productId = $_POST['productId'];
                $currentProductData = $modelProduct->getOneProduct($productId);
                $currentImg = $currentProductData['image'];
                $currentImgID = $currentProductData['imgId'];

                // var_dump($currentImg);
                // var_dump($currentImgID);

                // die;

                // //on vérifie s'il y a déjà une image d'enregistré (si c'est une update)
                if (isset($currentImg)) {
                        //si oui, on supprime l'ancienne image du serveur
                        $oldImgPath = $uploadDir . $currentImg;
                        if (file_exists($oldImgPath)) {
                                unlink($oldImgPath);
                        }
                        //et de la table image
                        $modelGalery->deleteImage($currentImgID);

                }

                if (move_uploaded_file($imgFile, $imagePath)) {
                        $addNew = [
                                $currentProductData['name'],
                                $imgName,
                        ];

                        //et on l'enregistre dans la db
                        $imgId = $modelGalery->creatNew($addNew);


                        //on mets à jour le produit
                        $newData = [
                                'id' => $currentProductData['id'],
                                'name' => $currentProductData['name'],
                                'cat_id' => $currentProductData['cat_id'],
                                'descript' => $currentProductData['descript'],
                                'ingredients' => $currentProductData['ingredients'],
                                'price' => $currentProductData['price'],
                                'img' => $imgId,
                        ];

                        $modelProduct->updateProduct($newData);

                        
                        // $success = "L'image a bien été enregistrée !";
                        // $_SESSION['visitor']['flash_message'] = [
                        //         'success' => $success
                        // ];
                        echo json_encode(["success" => true]);
                } else {
                        echo json_encode(["success" => false]);
                }
        }
} 