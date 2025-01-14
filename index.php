<?php
// index.php 

session_start();

// Include the database configuration
require_once 'db_config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login (if form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            // Redirect to dashboard
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
}

// Close the database connection
$conn->close(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Google Accounts</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <div id="auth-section">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>

    <div id="dashboard" style="display: none;"> 
        <h1>Welcome, <span id="username"></span>!</h1> 

        <h2>Your Google Accounts:</h2>
        <ul id="account-list">
            </ul>

        <button id="add-account">Add Account</button>
    </div>

    <script src="script.js"></script> 
</body>
</html>
