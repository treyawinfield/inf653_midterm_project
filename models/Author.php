<?php 
    class Author {
        // DB details
        private $conn;
        private $table = 'authors';

        // Author class properties
        public $id;
        public $author;

        // Constructor, Pass in database
        public function __construct($db) {
            // Set connection to database
            $this->conn = $db;
        }

        // Method to read/get Authors
        public function read() {
            // Create query
            $query = 'SELECT id, author
                FROM ' . $this->table;  ' a
                ORDER BY a.id';         

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
      
        // Get single Author
        public function read_single() {
            // Create query
            $query = 'SELECT id, author
                FROM ' . $this->table . ' a
                WHERE   
                    id = :id';   // named parameter vs positional parameter (both ok here)
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id
            $stmt->bindParam('id', $this->id);

            // Execute query
            $stmt->execute();

            // Fetch associative array that will be returned by $query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Determine if there is an author for the specified row
            if (isset($row['author'])) {
                $this->author = $row['author'];
                $result = $this->author;
            }
            else {
                $result = null;
            }

            return $result;
        }
      
        // Create Author
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    author = :author';   // use named parameters

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data, wrap in security functions (no html special chars or tags)
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind named parameter to object's author property
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()) {
                // NOTE: per Traversy, not returning data here, rather creating it
                // true indicates that query executed successfully
                return true;
            }
            
            //Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
       
        // Update Author
        public function update() {
            // Update query, WHERE clause indicates which author id to update
            $query = 'UPDATE ' . $this->table . '
                SET
                    author = :author
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data, wrap in security functions (no html special chars or tags)
            // Clean all named parameters including id
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
       
        // Delete Author
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' 
                WHERE 
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data, only need id
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