<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "investment_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data is sent via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize input data
    $investment_amount = filter_var($_POST['investment'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $interest_rate = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $years = filter_var($_POST['years'], FILTER_SANITIZE_NUMBER_INT);
    $compoundFreq = filter_var($_POST['compoundFreq'], FILTER_SANITIZE_NUMBER_INT);
    $future_value = filter_var($_POST['futureValue'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO investments (investment_amount, interest_rate, years, compounding_frequency, future_value) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ddidd", $investment_amount, $interest_rate, $years, $compoundFreq, $future_value);

    // Execute statement
    if ($stmt->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method!";
}
?>
