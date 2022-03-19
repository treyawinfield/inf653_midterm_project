<?php 
    // Additional Headers for PUT request 
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure $data's parameters are not empty
    if (empty($data->id) || empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Make sure the author id exists
    $authorExists = isValidId($data->id, $author);
    if (!$authorExists) {
        // No rows exist with the given author id
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
        exit();
    }

    // Assign what's in $data to the Author object
    // Set id to be updated as well since it's included in query
    $author->id = $data->id;
    $author->author = $data->author;

    // Update author, call update() method
    if($author->update()) {
        // display as json associative array
        echo json_encode(
            array('id' => $author->id, 'author' => $author->author)
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
        exit();
    }
?>