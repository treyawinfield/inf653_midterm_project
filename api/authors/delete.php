<?php
    // Additional Headers for DELETE request
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Get raw posted data
    // The POST data will be in json format so need to decode
    // file_get_contents reads entire file into a string
    // php://input is a read-only stream that allows you to read raw data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Make sure $data's id parameter is not empty
    if (empty($data->id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameter')
        );
        exit(); 
    }

    // Make sure the author id exists
    $authorExists = isValidId($data->id, $author);
    if (!$authorExists) {
        // No rows exist with the given author id
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        exit();
    }

    // Set ID to update
    $author->id = $data->id;

    // Delete post
    if($author->delete()) {
        // display as json associative array
        echo json_encode(
            array('id' => $author->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Deleted')
        );
    }

?>