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

    // Get the ID
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->readSinglePost();

    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body'=> $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name   
      );

      print_r(json_encode($post_arr));
?>