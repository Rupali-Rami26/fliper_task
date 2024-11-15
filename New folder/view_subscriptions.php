<?php
// Database connection
$host = 'localhost';
$db_name = 'projects_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all subscribed emails
    $stmt = $conn->prepare("SELECT * FROM subscribed_emails ORDER BY subscribed_at DESC");
    $stmt->execute();
    
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($subscriptions);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
