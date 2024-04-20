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

    // Prepare and execute SQL statement to fetch user from database
    $sql = "SELECT * FROM staff WHERE staffUserID = ? AND staffPassword = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staffUserID, $staffPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, redirect to markdummy.html
        header("Location: markdummy.html");
        exit(); // Terminate the script to prevent further execution
    } else {
        // User not found or invalid credentials
        echo "Invalid username or password";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
