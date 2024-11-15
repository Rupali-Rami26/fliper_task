<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the testimonial ID from the GET request
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the testimonial from the database
        $stmt = $conn->prepare("DELETE FROM client_testimonials WHERE id = ?");
        $stmt->execute([$id]);
        echo "Testimonial deleted successfully!";
    } else {
        echo "No testimonial ID provided!";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
