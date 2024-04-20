<?php
// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "mark"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $staffUserID = $_POST["staffUserID"];
    $staffPassword = $_POST["staffPassword"];

    // Prepare and execute SQL statement to insert record
    $sql = "INSERT INTO staff (staffUserID, staffPassword) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staffUserID, $staffPassword);

    if ($stmt->execute()) {
        // Record inserted successfully
        echo "Signup successful";
    } else {
        // Error inserting record
        echo "Error: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
