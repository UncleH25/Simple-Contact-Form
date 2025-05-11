<?php
// This script processes form submissions from a contact form.

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phoneNumber = trim($_POST["phone number"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400); // Bad Request
        echo "Please fill out all required fields.";
        exit;
    }

    // (Optional) Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo "Invalid email format.";
        exit;
    }

    // Database connection details
    $dbHost = "localhost";
    $dbUser = "root"; 
    $dbPass = "";
    $dbName = "simple_contact_form_db";

    // Connect to the database
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        echo "Database connection failed: " . $conn->connect_error;
        exit;
    }

    // Insert the form data into the database
    $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phoneNumber, $message);

    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo "Form submitted successfully!";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Failed to save the form data.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If not a POST request, return a 405 Method Not Allowed response
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>