<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $mobile_number = $_POST['mobile_number'];
        $city = $_POST['city'];

        // Insert data into contact_form table
        $stmt = $conn->prepare("INSERT INTO contact_form (full_name, email, mobile_number, city) 
                                VALUES (:full_name, :email, :mobile_number, :city)");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile_number', $mobile_number);
        $stmt->bindParam(':city', $city);

        // Execute the statement
        $stmt->execute();

        // Redirect after form submission
        header('Location: thank_you.php');
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
