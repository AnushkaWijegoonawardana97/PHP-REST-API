<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../modal/Category.php';

    // Initiating Database Connection
    $database = new Database();
    $db = $database->connect(); 

    // Initiating The Category
    $category = new Category($db);

    $results = $category->getCategory();
    $rowCount = $results->rowCount();

    if($rowCount > 0) {
        // Post Array
        $cats_arr =  array();
        $cats_arr['data'] = array();

        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
           extract($row);

           $cat_item = array(
             'id' => $id,
             'name' => $name,
           );

            // Push to 'data'
            array_push($cats_arr['data'], $cat_item);

            // Turn into json output
            echo json_encode($cats_arr);
        }
    } else {
        echo json_encode(
            array('message' => "No categories are found in the database")
        ); 
    }
?>