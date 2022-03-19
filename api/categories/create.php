<?php 
    // Headers
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Get the raw data that's POSTed (i.e. 'category' from URL)
    $data = json_decode(file_get_contents("php://input"));
    
    // Make sure $data's category parameter is not empty
    if (empty($data->category)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign what's in $data to the Category object
    $category->category = $data->category;

    // Create category, call create() method
    // Place inside if-statement in case the call fails (for example, if query in model fails)
    if($category->create()) {
        // get id value of last insert
        $last_id = $db->lastInsertId();
        // display category as json associative array
        echo json_encode(
            array('id' => $last_id, 'category' => $category->category)
        );
        exit();
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
        exit();
    }
?>