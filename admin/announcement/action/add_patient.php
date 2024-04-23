<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

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

// Get data from the POST request and sanitize it
$description = validateAndSanitizeInput($_POST['description']);
$title = validateAndSanitizeInput($_POST['title']);
$date = date('Y-m-d'); // Adjust the format according to your needs
$time = date('H:i:s'); // Adjust the format according to your needs

// Prepare and execute the SQL query
$sql = "INSERT INTO announcements (description, title, date, time) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $description, $title, $date, $time);

if ($stmt->execute()) {
    // Successful insertion
    echo 'Success';
} else {
    // Error handling
    echo 'Error: ' . $conn->error;
}

$stmt->close();
$conn->close();
?>