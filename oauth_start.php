<?php
// oauth_start.php 

require_once 'vendor/autoload.php'; // Include Google API Client Library

session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php"); 
    exit();
}

// Google API Client configuration
$client = new Google_Client();
$client->setClientId('your_client_id');
$client->setClientSecret('your_client_secret');
$client->setRedirectUri('your_redirect_uri'); // This should be the URL of this script
$client->addScope("email");
$client->addScope("profile");

// Generate the authorization URL
$auth_url = $client->createAuthUrl();

// Redirect the user to Google for authorization
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit();
?>