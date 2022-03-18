<?php 
    class Category {
        // DB details
        private $conn;
        private $table = 'categories';

        // Category class properties
        public $id;
        public $category;

        // Constructor, Pass in database
        public function __construct($db) {
            // set connection to database
            $this->conn = $db;
        }

        // Method to read/get categories
        public function read() {
            // Create query
            $query = 'SELECT id, category
                FROM ' . $this->table;           

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
      
        // Get single Category
        public function read_single() {
            // Create query
            $query = 'SELECT id, category
                FROM ' . $this->table . ' c
                WHERE   
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id
            $stmt->bindParam('id', $this->id);

            // Execute query
            $stmt->execute();

            // Fetch associative array that will be returned by $query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Determine if there is a category for the specified row
            if (isset($row['category'])) {
                $this->category = $row['category'];
                $result = $this->category;
            }
            else {
                $result = null;
            }

            return $result;
        }
      
        // Create Category
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    category = :category';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data, wrap in security functions (no html special chars or tags)
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind named parameter to object's category property
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute()) {
                // NOTE: per Traversy, not returning data here, rather creating it
                // true indicates that query executed successfully
                return true;
            }

            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
       
        // Update Category
        public function update() {
            // Update query, WHERE clause indicates which category id to update
            $query = 'UPDATE ' . $this->table . '
                SET
                    category = :category
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data, wrap in security functions (no html special chars or tags)
            // Clean all named parameters including id
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong w/ query
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
       
        // Delete Category
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