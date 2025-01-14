// script.js

// --- Authentication Section ---

// (1) Handle Login Form Submission (similar to previous example)
// ...

// --- Dashboard Section ---

// (2) Fetch and Display Google Accounts (similar to previous example)
// ...

// (3) Handle Account Switching
function handleAccountSwitch(event) {
    const accountId = event.currentTarget.dataset.accountId;

    // Send AJAX request to your PHP script to get the access token for this account
    fetch(`switch_account.php?account_id=${accountId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const accessToken = data.access_token;

            // 1. (Optional) Visually indicate the active account on the UI
            // 2. Use the access token to make API calls to Google services
            //    (You'll need to include the access token in the Authorization header 
            //     of your API requests)
            console.log("Access Token:", accessToken); // Example: Log the access token
        } else {
            console.error("Error switching accounts:", data.error);
            // Handle error (e.g., display an error message on the dashboard)
        }
    })
    .catch(error => {
        console.error('Error fetching access token:', error);
        // Handle error (e.g., display an error message on the dashboard)
    });
}

// (4) Handle Add Account Button Click (similar to previous example)
// ...