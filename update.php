<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set and not empty
    if (isset($_POST["rollNo"]) && isset($_POST["iat1"]) && isset($_POST["iat2"]) && isset($_POST["pt1"]) && isset($_POST["pt2"]) && isset($_POST["assignment"])) {
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

        // Prepare and execute SQL statement to update record
        $rollNo = $_POST["rollNo"];
        $iat1 = $_POST["iat1"];
        $iat2 = $_POST["iat2"];
        $pt1 = $_POST["pt1"];
        $pt2 = $_POST["pt2"];
        $assignment = $_POST["assignment"];
        
        $totalMarks = $iat1 + $iat2 + $pt1 + $pt2 + $assignment;
        $internalMarks = $totalMarks / 5;

        $sql = "UPDATE marks SET iat1 = ?, iat2 = ?, pt1 = ?, pt2 = ?, assignment = ?, internalMarks = ? WHERE rollNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiids", $iat1, $iat2, $pt1, $pt2, $assignment, $internalMarks, $rollNo);

        if ($stmt->execute()) {
            // Record updated successfully
            echo "Record updated successfully";
        } else {
            // Error updating record
            echo "Error: " . $conn->error;
        }

        // Close connection
        $conn->close();
    } else {
        // Not all fields are set or empty
        echo "All fields are required";
    }
} else {
    // Form is not submitted
    echo "Invalid request";
}
?>
