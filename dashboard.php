<?php
// dashboard.php

session_start();

// Include the database configuration
require_once 'db_config.php'; 

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php"); 
    exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's Google accounts
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM user_google_accounts WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$accounts = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $accounts[] = $row;
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

    <div id="dashboard"> 
        <h1>Welcome, <span id="username"><?php echo $_SESSION["username"]; ?></span>!</h1> 

        <h2>Your Google Accounts:</h2>
        <ul id="account-list">
            <?php foreach ($accounts as $account): ?>
                <li data-account-id="<?php echo $account['id']; ?>">
                    <?php if ($account['profile_image']): ?>
                        <img src="<?php echo $account['profile_image']; ?>" alt="<?php echo $account['email']; ?>">
                    <?php endif; ?>
                    <?php echo $account['email']; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <button id="add-account">Add Account</button>
    </div>

    <script src="script.js"></script> 
</body>
</html>