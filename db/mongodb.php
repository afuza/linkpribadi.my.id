<?php
require '../vendor/autoload.php';

use MongoDB\Exception;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;

try {
    $uri = "mongodb://localhost:27017";
    
    // Specify Stable API version 1
    $apiVersion = new ServerApi(ServerApi::V1);
    
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);
    
    // Replace 'your_database' with the actual name of your database
    $database = $client->selectDatabase('linkpribadi');
    
    // Send a ping to confirm a successful connection
    $database->command(['ping' => 1]);

} catch (Exception $e) {
    // Log the exception or display a more informative error message
    error_log("MongoDB Connection Error: " . $e->getMessage());
    // Optionally, you can display an error message to the user
    echo "An error occurred while connecting to MongoDB. Please try again later.";
}