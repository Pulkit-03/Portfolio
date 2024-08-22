<?php
// Database connection parameters
$host = 'customerfeedback.cz1xt7qxbbzq.ap-south-1.rds.amazonaws.com'; // Replace with your RDS endpoint
$username = 'pulkit';
$password = 'pulkit123';
$database = 'Customerfeedback';

// Create a connection to the database
$connection = new mysqli($host, $username, $password);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Create the database if it doesn't exist
$createDatabaseSql = "CREATE DATABASE IF NOT EXISTS $database";
if ($connection->query($createDatabaseSql) !== true) {
    die("Error creating database: " . $connection->error);
}

// Select the database
$connection->select_db($database);

// Create the feedback_table if it doesn't exist
$createTableSql = "CREATE TABLE IF NOT EXISTS feedback_table (
    name VARCHAR(255),
    email VARCHAR(255),
    feedback TEXT
)";
if ($connection->query($createTableSql) !== true) {
    die("Error creating table: " . $connection->error);
}

// Retrieve data from the submitted form
$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

// Insert data into the feedback table
$insertSql = "INSERT INTO feedback_table (name, email, feedback) VALUES (?, ?, ?)";

// Prepare the SQL statement
$stmt = $connection->prepare($insertSql);

// Bind the parameters
$stmt->bind_param("sss", $name, $email, $feedback);

// Execute the statement
if ($stmt->execute()) {
    echo "Feedback submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$connection->close();
?>
 