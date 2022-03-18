<?php 
    // Quotes query, call read method
    $result = $quote->read();

    // Get row count from result of calling read() method
    $num = $result->rowCount();

    // Check if any quotes
    // If num value is greater than 0, there are quotes
    if($num > 0) {
        // Quote array to hold all the row values
        $quotes_arr = array();

        // Loop through $result, fetch each row as an associative array
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Allows use of Quote properties in the row, such as $id, $quote, $author, $category
            extract($row);

            // Create quote item for each quote, pass in property values
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            // Push each quote item to quote array
            array_push($quotes_arr, $quote_item);
        }

        // Turn PHP associative array from while-loop into JSON and output
        echo json_encode($quotes_arr);
    } else {
        // Row count is 0, No Quotes in table
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        exit();
    }
?>