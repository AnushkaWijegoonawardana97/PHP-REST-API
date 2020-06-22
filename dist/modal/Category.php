<?php
    class Category {
        // Database Connection
        private $connection;
        private $table = 'categories';

        // Categories Properties
        public $id;
        public $name;
        public $created_at;

        // Constructor with database
        public function __construct($db)
        {
            $this->connection = $db;   
        }

        // Get Category
        public function getCategory() {
            // Create Query
            $query = 'SELECT
                id,
                name,
                created_at
            FROM
                ' . $this->table . '
            ORDER BY
                created_at DESC
            ';


            // Prepared Statment
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }
?>