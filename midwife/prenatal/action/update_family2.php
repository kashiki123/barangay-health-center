<?php
// Include your database configuration file
include_once ('../../../config.php');

// Initialize variables
$primary_id = $description = $diagnosis = $medicine = '';

// Check if POST data is set
if (isset ($_POST['primary_id'], $_POST['description'], $_POST['diagnosis'], $_POST['medicine'])) {
    // Sanitize input data
    $primary_id = filter_var($_POST['primary_id'], FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $diagnosis = filter_var($_POST['diagnosis'], FILTER_SANITIZE_STRING);
    $medicine = filter_var($_POST['medicine'], FILTER_SANITIZE_STRING);

    // Validate input data (example: check if primary_id is not empty and a positive integer)
    if (empty ($primary_id) || !filter_var($primary_id, FILTER_VALIDATE_INT) || $primary_id <= 0) {
        echo 'Error: Invalid primary ID';
        exit;
    }
} else {
    echo 'Error: Required input data missing';
    exit;
}

try {
    // Start a transaction
    $conn->begin_transaction();

    // Prepare and execute the update statement for prenatal_consultation
    $consultationUpdateSql = "UPDATE prenatal_consultation SET description=?, diagnosis=?, medicine=? WHERE id=?";
    $consultationStmt = $conn->prepare($consultationUpdateSql);
    $consultationStmt->bind_param("sssi", $description, $diagnosis, $medicine, $primary_id);
    $consultationUpdateSuccess = $consultationStmt->execute();

    // Check if update was successful
    if ($consultationUpdateSuccess) {
        // Commit the transaction if the update was successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if the update failed
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statement for consultation
    $consultationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>