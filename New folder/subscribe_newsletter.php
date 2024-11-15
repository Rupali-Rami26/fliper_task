<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the email address from the request
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';

    // Insert the email into the database
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Send a success response
    echo json_encode(["success" => true, "message" => "You have successfully subscribed to the newsletter!"]);
} catch (PDOException $e) {
    // Handle errors
    http_response_code(500);
    echo json_encode(["error" => "Failed to subscribe: " . $e->getMessage()]);
}
?>
