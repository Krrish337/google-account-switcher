<?php
// oauth_callback.php 

require_once 'vendor/autoload.php'; // Include Google API Client Library

session_start();

// Include the database configuration
require_once 'db_config.php'; 

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php"); 
    exit();
}

// Google API Client configuration (same as oauth_start.php)
$client = new Google_Client();
$client->setClientId('your_client_id');
$client->setClientSecret('your_client_secret');
$client->setRedirectUri('your_redirect_uri'); // This should be the URL of this script
$client->addScope("email");
$client->addScope("profile");

// Handle the OAuth 2.0 server response
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile information
    $google_oauth = new Google_Service_Oauth2($client);
    $user_info = $google_oauth->userinfo->get();

    // Store tokens and user info in the database
    $user_id = $_SESSION["user_id"];
    $google_account_id = $user_info->id;
    $access_token = $token['access_token'];
    $refresh_token = $token['refresh_token'];
    $email = $user_info->email;
    $profile_image = $user_info->picture;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO user_google_accounts (user_id, google_account_id, access_token, refresh_token, email, profile_image) 
            VALUES ('$user_id', '$google_account_id', '$access_token', '$refresh_token', '$email', '$profile_image')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to dashboard or display success message
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close(); 

} else {
    // Handle error - no authorization code received
}
?>