<?php

require_once './models/Database.php';
require_once './models/Products.php';
require_once './models/Categories.php';

// Function to update the data in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $products = new Models\Products();
        $categories = new Models\Categories();
        $input = json_decode(file_get_contents('php://input'), true);

        $type = $input['type'];
        $id = $input['id'];

        if($type === 'product'){
                $currentProduct = $products->getOneProduct($id);
                $newData = [
                                'id' => $id,
                                'active' => ($currentProduct['active'] ? 0 : 1)
                        ];
                $products->updateProduct($newData);

                $response = array('status' => 'success', 'message' => 'Les données ont bien été modifiées');
        } else {
                $currentCat = $categories->getOneCategory($id);
                $newData = [
                        'id' => $id,
                        'active' => ($currentCat['active'] ? 0 : 1)
                ];
                $categories->updateCategory($newData);

                $response = array('status' => 'success', 'message' => 'Les données ont bien été modifiées');
        }
        
} else {
        // Return an error response if the request method is not POST
        $response = array('status' => 'error', 'message' => 'Une erreur est survenue lors de l\'envoi de la requête');
}

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Convert the response array to JSON format and echo it
echo json_encode($response);
