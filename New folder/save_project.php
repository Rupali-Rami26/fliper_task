<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get form data
        $project_name = $_POST['project_name'];
        $project_description = $_POST['project_description'];

        // Handle image upload
        if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
            $image = $_FILES['project_image'];
            $image_name = basename($image['name']);
            $image_temp = $image['tmp_name'];
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . uniqid() . "_" . $image_name;

            // Validate and move the uploaded file
            if (move_uploaded_file($image_temp, $image_path)) {
                // Insert project data into the database
                $stmt = $conn->prepare("INSERT INTO projects (name, description, image) VALUES (:name, :description, :image)");
                $stmt->bindParam(':name', $project_name);
                $stmt->bindParam(':description', $project_description);
                $stmt->bindParam(':image', $image_path);
                $stmt->execute();

                // Redirect to success page or admin panel
                header('Location: admin_panel.php');
                exit();
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "No image uploaded or an error occurred during the upload.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
