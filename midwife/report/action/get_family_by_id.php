<?php
// Include your database configuration file
include_once('../../../config.php');


$dataId = $_POST['primary_id'];

try {
 
    $sql = "SELECT *,family_plannings.id as id
    FROM family_plannings
    JOIN patients ON family_plannings.patient_id = patients.id
    JOIN nurses ON family_plannings.nurse_id = nurses.id
    WHERE family_plannings.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $myData = $result->fetch_assoc();

  
        header('Content-Type: application/json');
        echo json_encode($myData);
    } else {
        throw new Exception('Error fetching  data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
