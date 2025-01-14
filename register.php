<?php
// register.php

session_start();

// Include the database configuration
require_once 'db_config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration (if form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page 
        header("Location: index.php"); 
        exit();
    } else {
        // Display error message on the page
        $error_message = "Error: " . $sql . "<br>" . $conn->error; 
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <div id="auth-section">
        <h2>Register</h2>

        <?php if (isset($error_message)): ?> 
            <p style="color: red;"><?php echo $error_message; ?></p> 
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" name="register" value="Register">
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>

</body>
</html>
