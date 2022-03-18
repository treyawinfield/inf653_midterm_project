<?php 
    // Include/Require Statements
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    function isValidId($id, $model) {
        // Use the $id passed in to set the id of the $model
        $model->id = $id;

        // Get the result of $model read_single method
        $result = $model->read_single();

        return $result;
    }
?>
