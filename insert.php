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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $rollNo = $_POST['rollNo'];
    $subjectCode = $_POST['subjectCode'];
    $iat1 = $_POST['iat1'];
    $iat2 = $_POST['iat2'];
    $pt1 = $_POST['pt1'];
    $pt2 = $_POST['pt2'];
    $assignment = $_POST['assignment'];

    // Prepare and bind SQL statement
    $stmt_check = $conn->prepare("SELECT * FROM marks WHERE rollNo = ? AND subjectCode = ?");
    $stmt_check->bind_param("ss", $rollNo, $subjectCode);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Duplicate entry. Record with the same roll number and subject code already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO marks (rollNo, subjectCode, iat1, iat2, pt1, pt2, assignment, internalMarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiiid", $rollNo, $subjectCode, $iat1, $iat2, $pt1, $pt2, $assignment, $internalMarks);

        // Calculate internal marks
        $totalMarks = $iat1 + $iat2 + $pt1 + $pt2 + $assignment;
        $internalMarks = $totalMarks / 5;

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close statement for duplicate check
    $stmt_check->close();
}

// Close connection
$conn->close();
?>
