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

    // Fetch all contacts
    $stmt = $conn->prepare("SELECT * FROM contacts ORDER BY created_at DESC");
    $stmt->execute();
    
    // Fetch data as an associative array
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Respond with JSON
    header('Content-Type: application/json');
    echo json_encode($contacts);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch contacts: " . $e->getMessage()]);
}
?>
