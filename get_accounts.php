<?php
// get_accounts.php 

session_start();

// Include the database configuration
require_once 'db_config.php'; 

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Return an error response (you might want to handle this differently in your JavaScript)
    echo json_encode(['error' => 'User not logged in']); 
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

// Return accounts as JSON
echo json_encode($accounts); 
?>