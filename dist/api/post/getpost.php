<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../modal/Post.php';

    // Initiating Database Connection
    $database = new Database();
    $db = $database->connect();


    // Initiating The Blog Post
    $post = new Post($db);

    $results = $post->readPost();
    $rowCount = $results->rowCount();

    if($rowCount > 0) {
        // Post Array
        $posts_arr =  array();
        $posts_arr['data'] = array();

        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
           extract($row);

           $post_item = array(
             'id' => $id,
             'title' => $title,
             'body'=> html_entity_decode($body),
             'author' => $author,
             'category_id' => $category_id,
             'category_name' => $category_name   
           );

            // Push to 'data'
            array_push($posts_arr['data'], $post_item);

            // Turn into json output
            echo json_encode($posts_arr);
        }
    } else {
        echo json_encode(
            array('message' => "No posts are found in the database")
        ); 
    }
?>