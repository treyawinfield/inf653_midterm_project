<?php 
    class Quote {
        // DB details
        private $conn;
        private $table = 'quotes';

        // Quote class properties
        public $id;
        public $quote;
        public $authorId;
        public $categoryId;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            // Create query
            $query = 'SELECT id, quote, authorId, categoryId
                FROM ' . $this->table .  
               'ORDER BY
                    id DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }


        // Get single Quote
        public function read_single() {
            // Create query
            $query = 'SELECT id, quote, authorId, categoryId
                FROM ' . $this->table .
                'WHERE   
                    id = ?
                LIMIT 0,1';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Set properties
            $this->quote = $row['quote'];
        }


        // Create Quote
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    quote = :body,
                    authorId = :authorId,
                    categoryId = :categoryId';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        
        // Update Quote
        public function update() {
            // Update query 
            $query = 'UPDATE ' . $this->table . '
                SET
                    quote = :body,
                    authorId = :authorId,
                    categoryId = :categoryId
                WHERE
                    id = :id';
            
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }


        // Delete Quote
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>