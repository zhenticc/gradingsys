<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $email = $_POST["email"];
    $userPassword = $_POST["password"];

    // Connect to the MySQL database
    $servername = "localhost";
    $username = "root";
    $dbPassword = "";
    $database = "ptcgradesys";

    $conn = new mysqli($servername, $username, $dbPassword, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if (password_verify($userPassword, $hashedPassword)) {
            // Password is correct, user is logged in

            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid password!";
        }
    } elseif ($result->num_rows === 0) {
        // User not found
        echo "User not found!";
    } else {
        // Error occurred
        echo "An error occurred while processing your request.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
