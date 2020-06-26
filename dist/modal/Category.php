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

        // Get Single Category
        public function getsingCat() {
            // Create Query
            $query =  'SELECT id, name, created_at FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1 ';

            // Prepare Statement
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }

        // Create Category
        public function postCategory() {
            $query = 'INSERT INTO ' . $this->table . ' SET id = :id, name = :name';
            $stmt = $this->connection->prepare($query);

            $this->id =  htmlspecialchars(strip_tags($this->id));
            $this->name =  htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()) {
                return true;
            } 

            // Something Went Wrong
            printf("Error: %s. \n", $stmt->error);
            
            return false;
        }

        // Update Category
        public function updateCategory() {
            $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id ';

            $stmt = $this->connection->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Delete Category
        public function deleteCategory() {
            $query = ' DELETE FROM ' . $this->table . ' WHERE id = :id ';

            $stmt= $this->connection->prepare($query);
            
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);
            
            return false;
        }
    }
?>