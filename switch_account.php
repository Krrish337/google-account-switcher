<?php
// switch_account.php

session_start();

// Include the database configuration
require_once 'db_config.php'; 

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Check if account_id is provided
if (!isset($_GET['account_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing account_id']);
    exit();
}

$account_id = $_GET['account_id'];
$user_id = $_SESSION["user_id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the access token for the specified account
$sql = "SELECT access_token, refresh_token FROM user_google_accounts 
        WHERE id = '$account_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $access_token = $row['access_token'];
    $refresh_token = $row['refresh_token'];

    // (Optional) Check if the access token is expired, and if so, refresh it
    // ... (Code to refresh the access token if needed) ...

    echo json_encode(['success' => true, 'access_token' => $access_token]);
} else {
    echo json_encode(['success' => false, 'error' => 'Account not found']);
}

// Close the database connection
$conn->close(); 
?>