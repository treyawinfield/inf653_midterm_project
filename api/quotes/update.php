<?php 
    // Header
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure none of $data's parameters are empty
    if (empty($data->id) || empty($data->quote) || empty($data->authorId) || empty($data->categoryId)) {
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

    // Make sure the author exists
    $authorExists = isValidAuthorId($data->authorId, $quote);
    if (!($authorExists > 0)) {
        // No rows exist with the given authorId
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
        exit();
    }

    // Make sure the category exists
    $categoryExists = isValidCategoryId($data->categoryId, $quote);
    if (!($categoryExists > 0)) {
        // No rows exist with the given categoryId
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
        exit();
    }

    // Update properties
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->authorId = $data->authorId;
    $quote->categoryId = $data->categoryId;

    // Update author
    if($quote->update()) {
        // display as json associative array
        echo json_encode(
            array('id' => $quote->id, 'quote' => $quote->quote, 'authorId' => $quote->authorId, 'categoryId' => $quote->categoryId)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Updated')
        );
    }
?>