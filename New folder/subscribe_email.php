<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if email is provided
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];

        // Prepare SQL query to insert email into the subscribers table
        $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Send success response
        echo json_encode(["success" => true]);
    } else {
        // Send error response if email is invalid
        echo json_encode(["success" => false, "error" => "Invalid email address"]);
    }
} catch (PDOException $e) {
    // Send error response if something goes wrong
    echo json_encode(["success" => false, "error" => "Error subscribing: " . $e->getMessage()]);
}
?>
