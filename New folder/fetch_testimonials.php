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

    // Fetch all testimonials
    $stmt = $conn->prepare("SELECT * FROM client_testimonials ORDER BY created_at DESC");
    $stmt->execute();
    
    // Fetch data as an associative array
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set response headers and return data as JSON
    header('Content-Type: application/json');
    echo json_encode($testimonials);

} catch (PDOException $e) {
    // Handle errors
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch testimonials: " . $e->getMessage()]);
}
?>
