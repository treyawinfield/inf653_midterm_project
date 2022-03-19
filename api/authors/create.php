<?php 
    // Additional Headers for POST request
    header('Access-Control-Allow-Methods: POST');
    // Actual Allowed Header Values
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Get the raw data that's POSTed (i.e. 'author' from URL)
    // The POST data will be in json format so need to decode
    // file_get_contents reads entire file into a string
    // php://input is a read-only stream that allows you to read raw data from the request body
    $data = json_decode(file_get_contents("php://input"));
    
    // Make sure $data's author parameter is not empty
    if (empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign what's in $data to the Author object
    $author->author = $data->author;

    // Create author, call create() method
    // Place inside if-statement in case the call fails (for example, if query in model fails)
    if($author->create()) {
        // get id value of last insert
        $last_id = $db->lastInsertId();
        // display as json associative array
        echo json_encode(
            array('id' => $last_id, 'author' => $author->author)
        );
        exit();
    } else {
        echo json_encode(
            array('message' => 'Author Not Created')
        );
        exit();
    }
?>