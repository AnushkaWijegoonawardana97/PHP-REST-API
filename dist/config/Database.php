<?php

    class Database {
        // Database Parameters
        private $host = 'localhost';
        private $db_name = 'php_restapi';
        private $username = 'root';
        private $password = 'Anushka123';
        private $conn;


        // Database Connection
        public function connect() {
            $this->conn = null;
      
            try { 
              $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
              echo 'Connection Error: ' . $e->getMessage();
            }
      
            return $this->conn;
          }
    }

?>