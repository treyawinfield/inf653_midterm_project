<?php 
    // Create array for author, pass in property values
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    // Make JSON
    echo json_encode($author_arr);
?>