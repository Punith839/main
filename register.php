<?php
// Database connection
$servername = "localhost";
$username = "root";   // default in XAMPP
$password = "";       // default in XAMPP
$dbname = "registrationDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT); // hashed password
    $dob        = $_POST['dob'];
    $address    = $_POST['address'];
    $college    = $_POST['college'];
    $gender     = $_POST['gender'];
    $courses    = isset($_POST['course']) ? implode(", ", $_POST['course']) : "";
    $department = $_POST['department'];
    $programs   = isset($_POST['programs']) ? implode(", ", $_POST['programs']) : "";
    $startTime  = $_POST['startTime'];
    $endTime    = $_POST['endTime'];

    // File Upload
    $fileName = $_FILES["fileUpload"]["name"];
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $targetFile = $targetDir . basename($fileName);
    move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFile);

    // Insert into database
    $sql = "INSERT INTO users (username, email, password, dob, address, college, gender, courses, department, programs, startTime, endTime, fileName)
            VALUES ('$username', '$email', '$password', '$dob', '$address', '$college', '$gender', '$courses', '$department', '$programs', '$startTime', '$endTime', '$fileName')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2 style='color:green; text-align:center;'>🎉 Registration Successful!</h2>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
