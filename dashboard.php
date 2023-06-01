<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    // User is not logged in, redirect to the login page
    header("Location: process-login.php");
    exit();
}

// Logout functionality
if (isset($_GET["logout"])) {
    // Clear the session data
    session_unset();
    session_destroy();

    // Redirect to the login page
    header("Location: process-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style4.css">
</head>

<body>
    <h1>Welcome to the Dashboard!</h1>

    <p>You are logged in as: <?php echo $_SESSION["email"]; ?></p>

    <a href="dashboard.php?logout=true">Logout</a>

    <script src="script.js"></script>
</body>

</html>