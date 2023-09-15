<?php

require_once './models/Database.php';
require_once './models/Horaires.php';

// Function to update the data in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Models\Database();
        $dates = new Models\Horaires();
        $input = json_decode(file_get_contents('php://input'), true);

        if (is_array($input)) {
                foreach ($input as $data) {
                        $newData = [
                                'id' => $data['day'],
                                'time' => $data['time'],
                                'city' => $data['city'],
                                'place' => $data['place']
                        ];
                        $dates->updateDate($newData);
                }
                $response = array('status' => 'success', 'message' => 'Les données ont bien été modifiées');
        } else {
                // Return an error response if the request data is not an array
                $response = array('status' => 'error', 'message' => 'Données invalides');
        }
} else {
        // Return an error response if the request method is not POST
        $response = array('status' => 'error', 'message' => 'Une erreur est survenue lors de l\'envoi de la requête');
}

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Convert the response array to JSON format and echo it
echo json_encode($response);