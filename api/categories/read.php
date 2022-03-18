<?php 
    // Categories query, call read method
    $result = $category->read();

    // Get row count from result of calling read() method
    $num = $result->rowCount();

    // Check if any categories
    // If num value is greater than 0, there are categories
    if($num > 0) {
        // Category array to hold all the row values
        $categories_arr = array();

        // Loop through $result, fetch each row as an associative array
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Allows use of Category properties in the row, such as $id, $category
            extract($row);   // instead of $row['id'] or $row['category'], etc.

            // Create category item for each category, pass in property values 
            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push each category item to category array
            array_push($categories_arr, $category_item);
        }

        // Turn PHP associative array from while-loop into JSON and output
        echo json_encode($categories_arr);
    } else {
        // Row count is 0, No Categories in table
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }
?>