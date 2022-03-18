<?php 
    // Authors query, call read method
    $result = $author->read();

    // Get row count from result of calling read() method
    $num = $result->rowCount();

    // Check if any authors
    // If num value is greater than 0, there are authors
    if($num > 0) {
        // Author array to hold all the row values
        $authors_arr = array();

        // Loop through $result, fetch each row as an associative array
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Allows use of Author properties in the row, such as $id, $author
            extract($row);  // instead of $row['id'] or $row['author'], etc.

            // Create author item for each author, pass in property values 
            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push each author item to author array
            array_push($authors_arr, $author_item);
        }

        // Turn PHP associative array from while-loop into JSON and output
        echo json_encode($authors_arr);
    } else {
        // Row count is 0, No Authors in table
        echo json_encode(
            array('message' => 'No Authors Found')
        );
        exit();
    }
?>