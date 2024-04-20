<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if Roll No is set and not empty
    if (isset($_POST["deleteRollNo"]) && !empty($_POST["deleteRollNo"])) {
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

        // Prepare and execute SQL statement to delete record
        $rollNo = $_POST["deleteRollNo"];
        $sql = "DELETE FROM marks WHERE rollNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $rollNo);

        if ($stmt->execute()) {
            // Record deleted successfully
            echo "Record deleted successfully";
        } else {
            // Error deleting record
            echo "Error: " . $conn->error;
        }

        // Close connection
        $conn->close();
    } else {
        // Roll No is not set or empty
        echo "Roll No is required";
    }
} else {
    // Form is not submitted
    echo "Invalid request";
}
?>
