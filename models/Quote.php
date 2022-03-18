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

        // Constructor with DB, Pass in database
        public function __construct($db) {
            // Set connection to database
            $this->conn = $db;
        }

        // Get Quotes
        public function read() { 
            if (isset($this->authorId) && isset($this->categoryId)) {
                $query = 'SELECT 
                    q.id, q.quote, a.author AS author, c.category AS category
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                WHERE 
                    q.authorId = :authorId AND q.categoryId = :categoryId'; 

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind parameters
                $stmt->bindParam('authorId', $this->authorId);
                $stmt->bindParam('categoryId', $this->categoryId);

                // Execute query
                $stmt->execute();

                return $stmt;
            }
            if (isset($this->authorId)) {
                $query = 'SELECT 
                    q.id, q.quote, a.author AS author, c.category AS category
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                WHERE 
                    q.authorId = :authorId'; 

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind parameters
                $stmt->bindParam('authorId', $this->authorId);

                // Execute query
                $stmt->execute();

                return $stmt;
            }
            if (isset($this->categoryId)) {
                $query = 'SELECT 
                    q.id, q.quote, a.author AS author, c.category AS category
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                WHERE 
                    q.categoryId = :categoryId'; 

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind parameters
                $stmt->bindParam('categoryId', $this->categoryId);

                // Execute query
                $stmt->execute();

                return $stmt;
            }

            // Create query to return all 
            $query = 'SELECT 
                    q.id, q.quote, a.author AS author, c.category AS category
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                ORDER BY
                    q.id';        

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
      
        // Get single Quote
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    q.id, q.quote, a.author AS author, c.category AS category
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                WHERE 
                    q.id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam('id', $this->id);

            // Execute query
            $stmt->execute();

            // Fetch associative array that will be returned by $query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Determine if there is a quote for the specified row
            if (isset($row['quote'])) {
                return $row;
            }
            else {
                return null;
            } 
        }
      
        // Create Quote
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    quote = :quote,
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
                    quote = :quote,
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
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':id', $this->id);

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