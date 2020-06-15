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
    }

?>