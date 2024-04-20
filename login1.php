<?php
// Database connection details
$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "mark"; // Your MySQL database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if roll number is provided in the POST request
if(isset($_POST['staffUserID'])) {
    // Retrieve roll number from the POST request
    $rollNo = $_POST['staffUserID'];
    
    // Prepare SQL query to select the record for the provided roll number
    $sql = "SELECT * FROM marks WHERE rollNo = '$rollNo'";
    
    // Execute SQL query
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                
                table th, table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                
                table th {
                    background-color: #f2f2f2;
                }
                
                table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                
                table tr:hover {
                    background-color: #ddd;
                }
                
                table th, table td {
                    text-align: left;
                }
            </style>";

        echo "<table>
                <tr>
                    <th>Roll No</th>
                    <th>Subject Code</th>
                    <th>IAT1</th>
                    <th>IAT2</th>
                    <th>PT1</th>
                    <th>PT2</th>
                    <th>Assignment</th>
                    <th>Internal Marks</th>
                </tr>";

        // Fetch and display the record
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['rollNo'] . "</td>";
            // Check if 'subjectCode' key exists in the row array
            if (array_key_exists('SubjectCode', $row)) {
                echo "<td>" . $row['SubjectCode'] . "</td>";
            } else {
                echo "<td>Subject Code not available</td>";
            }
            // echo "<td>" . $row['SubjectCode'] . "</td>";
            echo "<td>" . $row['iat1'] . "</td>";
            echo "<td>" . $row['iat2'] . "</td>";
            echo "<td>" . $row['pt1'] . "</td>";
            echo "<td>" . $row['pt2'] . "</td>";
            echo "<td>" . $row['assignment'] . "</td>";
            // Calculate internal marks
            $internalMarks = ($row['iat1'] + $row['iat2'] + $row['pt1'] + $row['pt2'] + $row['assignment']) / 5;
            echo "<td>" . number_format($internalMarks, 2) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No record found for roll number: $rollNo";
    }
} else {
    echo "Please provide a roll number";
}

// Close connection
mysqli_close($conn);
?>
