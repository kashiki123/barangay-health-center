<?php
// Include your database configuration file
include_once('../../../config.php');


// Function to sanitize input
function sanitize_input($input)
{
    //   // Remove all HTML tags using preg_replace
    //   $input = preg_replace("/<[^>]*>/", "", trim($input));
      // Use regular expression to remove potentially harmful characters
      $input = preg_replace("/[^a-zA-Z0-9\s]/", "", $input);
      // Remove SQL injection characters
      $input = preg_replace("/[;#\*--]/", "", $input);
      // Remove Javascript injection characters
      $input = preg_replace("/[<>\"\']/", "", $input);
      // Remove Shell injection characters
      $input = preg_replace("/[|&\$\>\<'`\"]/", "", $input);
      // Remove URL injection characters
      $input = preg_replace("/[&\?=]/", "", $input);
      // Remove File Path injection characters
      $input = preg_replace("/[\/\\\\\.\.]/", "", $input);
      // Remove control characters and whitespace
      $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
      //Remove script and content characters
      $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
      return $input;
}

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitize_input($input);
}

// Get updated patient data from the POST request and sanitize it
$patientId = (isset($_POST['patient_id'])) ? validateAndSanitizeInput($_POST['patient_id']) : null;
$description = (isset($_POST['description'])) ? validateAndSanitizeInput($_POST['description']) : '';
$title = (isset($_POST['title'])) ? validateAndSanitizeInput($_POST['title']) : '';
$date = date('Y-m-d'); // Adjust the format according to your needs
$time = date('H:i:s'); // Adjust the format according to your needs

try {
    // Validate that $patientId is not empty before proceeding with the update
    if (empty($patientId)) {
        throw new Exception('Invalid or missing patient ID');
    }

    // Update patient data in the database
    $sql = "UPDATE announcements SET description=?, title=?, date=?, time=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $description, $title, $date, $time, $patientId);

    if ($stmt->execute()) {
        // Successful update
        echo 'Success';
    } else {
        throw new Exception('Error updating patient: ' . $stmt->error);
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