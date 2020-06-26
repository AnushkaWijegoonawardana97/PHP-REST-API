<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow_methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../modal/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $category->id = $data->id;
    $category->name = $data->name;

    if($category->updateCategory()) {
        echo json_encode(
            array('message' => "Category Updated")
        );
    } else {
        echo json_encode (
            array('message' => 'Category not updated')
        );
    }
    
?>