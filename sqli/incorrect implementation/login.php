<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user credentials from the form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a connection to the database
    $conn = mysqli_connect("localhost", "root", "mysql", "login_db");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Construct the SQL statement with direct injection of user input (INCORRECT)
    $sql = "SELECT * FROM user WHERE name = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 1) {
        // User is authenticated, display a success message
        echo "Login successful!";
    } else {
        // Invalid username or password, display an error message
        echo "Invalid username or password.";
    }

    // Close the database connection
    mysqli_close($conn);
}
