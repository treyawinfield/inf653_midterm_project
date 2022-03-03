<?php 
    class Database {
        // DB Params
        private $host = 'eanl4i1omny740jw.cbetxkdyhwsb.us-east-1.rds.amazonaws.com	';
        private $db_name = 'sh8c38icjzsz9w7t';
        private $username = 'y7m11tf4hkiuh8sd';
        private $password = null;
        private $conn;

        // DB Constructor to access environmental variable
        public function __construct() {
            $this->password = getenv('DB_PASSWORD');
        }
        
        // DB Connect
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