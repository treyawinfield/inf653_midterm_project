<?php 
    // Headers
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

   // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure $data's parameters are not empty
    if (empty($data->id) || empty($data->category)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Make sure the category id exists
    $categoryExists = isValidId($data->id, $category);
    if (!$categoryExists) {
        // No rows exist with the given category id
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
        exit();
    }

    // Assign what's in $data to the Category object
    // Set id to be updated as well since it's included in query
    $category->id = $data->id;
    $category->category = $data->category;

    // Update category, call update() method
    if($category->update()) {
        // display as json associative array
        echo json_encode(
            array('id' => $category->id, 'category' => $category->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Updated')
        );
    }
?>