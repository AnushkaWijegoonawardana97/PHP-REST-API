<?php

    class Post {
        // Database Properties
        private $connection;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constructor with database
        public function __construct($db)
        {
            $this->connection = $db;   
        }

        // Get Posts 
        public function readPost() {
            // Create Query
            $query = 'SELECT
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM
                '. $this->table .' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';

            // Prepared Statment
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        // Get Single Post
        public function readSinglePost() {
            // Create Query
            $query = 'SELECT
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM
                '. $this->table .' p
            LEFT JOIN
                categories c ON p.category_id= c.id
            WHERE
                p.id = ?
            LIMIT 0,1 
            ';

            // Prepare Statment
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            

            // Set Properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            $this->created_at = $row['created_at'];
        }

        // Create Post
        public function createPost() {
            // Create Query
            $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

            // Prepare Statment
            $stmt = $this->connection->prepare($query);

            // Data Cleaning
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Data Binding
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            if($stmt->execute()) {
                return true;
            } 

            // Something Went Wrong
            printf("Error: %s. \n", $stmt->error);
            
            return false;
        }

        // Update Post
        public function updatePost() {
            // Create Query
            $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id = :id';

            // Prepare Statment
            $stmt = $this->connection->prepare($query);
 
            // Data Cleaning
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Data Binding
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            
            if($stmt->execute()) {
                return true;
            } 

            // Something Went Wrong
            printf("Error: %s. \n", $stmt->error);
            
            return false;
        }

        // Detele Post
        public function deletePost() {
            // Create Query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id ';

            // Prepare Statment
            $stmt = $this->connection->prepare($query);

            // Data Cleaning
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Data Binding
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            } 

            // Something Went Wrong
            printf("Error: %s. \n", $stmt->error);
            
            return false;
        }
    }

?>