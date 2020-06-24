<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../modal/Category.php';

    // Instantiate DB & Connection
    $database= new Database();
    $db= $database->connect();
    
    // Instantiate Category
    $category = new Category($db);
    
    // Get the created_at
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    $category->getsingCat();

    // Create Array
    $category_arr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at,
    );

    print_r(json_encode($category_arr));
?>