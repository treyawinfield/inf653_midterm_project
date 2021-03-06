<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Include/Require Statements
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once '../../function/isValidId.php';
    include_once '../../function/isValidAuthorId.php';
    include_once '../../function/isValidCategoryId.php';

    // Get the value of the HTTP request method
    $method = $_SERVER['REQUEST_METHOD'];

    // Headers for an OPTIONS request (CORS)
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    }

    // Instantiate DB & Connect
    $database = new Database();
    // Connect to DB using db variable
    $db = $database->connect();
    
    // Instantiate Category object
    // Pass db to constructor
    $category = new Category($db);
    
    // Route to appropriate CRUD 
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            // Get id from URL, Set $category's id to value from URL
            $id = $_GET['id'];
            // Call isValid() method to determine if a category exists at the given id
            $categoryExists = isValidId($id, $category);
            // Display error msg if no category exists at the given id
            if (!$categoryExists) {
                echo json_encode(
                    array ('message' => 'categoryId Not Found')
                );
                exit();
            }
            require_once('read_single.php');
            exit();
        }
        require_once('read.php');
        exit();
    }
    if ($method === 'POST') {
        require_once('create.php');
        exit();
    }
    if ($method === 'PUT') {
        require_once('update.php');
    }
    if ($method === 'DELETE') {
        require_once('delete.php');
    }  
?>