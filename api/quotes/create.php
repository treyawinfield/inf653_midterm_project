<?php 
    // Headers
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    //include_once '../../function/isValidAuthorId.php';

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure none of $data's parameters are empty
    if (empty($data->quote) || empty($data->authorId) || empty($data->categoryId)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }
    
    // Make sure the author exists
    $authorExists = isValidAuthorId($data->authorId, $quote);
    if (!($authorExists > 0)) {
        // No rows exist with the given authorId
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
        exit();
    }

    // Make sure the category exists
    $categoryExists = isValidCategoryId($data->categoryId, $quote);
    if (!($categoryExists > 0)) {
        // No rows exist with the given categoryId
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
        exit();
    }

    // Assign what's in $data to the Quote object
    $quote->quote = $data->quote;
    $quote->authorId = $data->authorId;
    $quote->categoryId = $data->categoryId;

    // Create quote, call create() method
    // Place inside if-statement in case the call fails (for example, if query in model fails)
    if($quote->create()) {
        // get id value of last insert
        $last_id = $db->lastInsertId();
        // display as json associative array
        echo json_encode(
            array('id' => $last_id, 'quote' => $quote->quote, 'authorId' => $quote->authorId, 'categoryId' => $quote->categoryId)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }
?>