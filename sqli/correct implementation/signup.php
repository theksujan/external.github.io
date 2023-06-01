<?php
// Retrieve user details from the form submission
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

// Create a connection to the database
$conn = mysqli_connect("localhost", "root", "mysql", "login_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement with parameter binding
$stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to login.html
    header("Location: login.html");
    exit(); // Make sure to exit after the redirect
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>
