<?php
    // Headers
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

   // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure $data's id parameter is not empty
    if (empty($data->id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameter')
        );
        exit(); 
    }

    // Make sure the quote id exists
    $quoteExists = isValidId($data->id, $quote);
    if (!$quoteExists) {
        // No rows exist with the given quote id
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        exit();
    }

    // Set ID to update
    $quote->id = $data->id;

    // Delete quote
    if($quote->delete()) {
        // display as json associative array
        echo json_encode(
            array('id' => $quote->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Deleted')
        );
    }

?>