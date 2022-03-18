<?php 
    // Set object properties
    $quote->quote = $quoteExists['quote'];
    $quote->author = $quoteExists['author'];
    $quote->category = $quoteExists['category'];
    
    // Create array for quote, pass in property values
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    );

    // Make JSON
    echo json_encode($quote_arr);
    exit();    
?>