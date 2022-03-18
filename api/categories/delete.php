<?php
    // Additional Headers for DELETE request
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

    // Make sure the category id exists
    $categoryExists = isValidId($data->id, $category);
    if (!$categoryExists) {
        // No rows exist with the given author id
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        exit();
    }

    // Set ID to update
    $category->id = $data->id;

    // Delete post
    if($category->delete()) {
        // display as json associative array
        echo json_encode(
            array('id' => $category->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }
?>