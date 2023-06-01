<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Perform validation and database operations
    if ($password === $confirmPassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Connect to the MySQL database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ptcgradesys";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email is already in use
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email is already in use
            echo "Email is already registered!";
        } else {
            // Insert the new user
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Close the database connection
            $conn->close();

            // Redirect the user to a success page or perform any additional actions
            echo "Signup successful!";
        }
    } else {
        echo "Passwords do not match!";
    }
}
