// The use of prepared statements with parameter binding ensures that user input is treated as data, preventing SQL injection//

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a connection to the database
    $conn = mysqli_connect("localhost", "root", "mysql", "login_db");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement using a prepared statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE name = ?"); // Use a placeholder '?' for the user input
    mysqli_stmt_bind_param($stmt, "s", $username); // Bind the user input as a parameter to the prepared statement
    mysqli_stmt_execute($stmt); // Execute the prepared statement

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // User is authenticated, display a success message
            echo "Login successful!";
        } else {
            // Invalid password, display an error message
            echo "Invalid password.";
        }
    } else {
        // Invalid username, display an error message
        echo "Invalid username.";
    }

    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
