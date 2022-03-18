<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Include/Require Statements
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
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

    // Instantiate DB
    $database = new Database();
    // Connect to DB 
    $db = $database->connect();
    
    // Instantiate Quote object
    $quote = new Quote($db);

    // Route to appropriate CRUD 
    if ($method === 'GET') {
        // If included, route to GET request parameters (i.e. 'id', 'authorId', 'categoryId') 
        // id parameter is included in the GET request
        if (isset($_GET['id'])) {
            // Get id value from the GET request
            $id = $_GET['id'];
            // Determine if a quote exists for the given id (can only be one)
            $quoteExists = isValidId($id, $quote);
            // Display error msg if no quote exists
            if (!$quoteExists) {
                echo json_encode(
                    array ('message' => 'No Quotes Found')
                );
                exit();
            }
            require_once('read_single.php');
            exit(); 
        }
        // authorId parameter is included in the GET request
        if (isset($_GET['authorId'])) {
            // Get authorId value
            $authorId = $_GET['authorId'];
            // Determine if any quotes exist for the given authorId (can be more than one)
            $authorExists = isValidAuthorId($authorId, $quote);
            // If 1 or more rows of quotes exist with the given authorId
            if ($authorExists > 0) {
                // Set authorId property
                $quote->authorId = $_GET['authorId'];
            }
            else  {
                // No rows exist with the given authorId
                echo json_encode(
                    array('message' => 'authorId Not Found')
                );
                exit();
            }
        }
        // categoryId parameter is included in the GET request
        if (isset($_GET['categoryId'])) {
            // Get categoryId value
            $categoryId = $_GET['categoryId'];
            // Determine if any quotes exist for the given categoryId (can be more than one)
            $categoryExists = isValidCategoryId($categoryId, $quote);
            // If 1 or more rows of quotes exist with the given categoryId
            if ($categoryExists > 0) {
                // Set categoryId property
                $quote->categoryId = $_GET['categoryId'];
            }
            else  {
                // No rows exist with the given authorId
                echo json_encode(
                    array('message' => 'categoryId Not Found')
                );
                exit();
            }
        }
        // Any set properties will be passed to read operation
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