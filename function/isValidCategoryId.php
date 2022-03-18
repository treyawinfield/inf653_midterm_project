<?php 
    // Include/Require Statements
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    function isValidCategoryId($categoryId, $model) {
        // Use the $id passed in to set the id of the $model
        $model->categoryId = $categoryId;

        // Get the result of $model read_single method
        $result = $model->read();

        // Get row count from result of calling read() method
        $num = $result->rowCount();

        return $num;
    }
?>