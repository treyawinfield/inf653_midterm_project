<?php 
    // Create array for category, pass in property values
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    // Make JSON
    echo json_encode($category_arr);
?>