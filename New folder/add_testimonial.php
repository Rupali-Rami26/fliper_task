<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $clientName = $_POST['clientName'];
        $clientDesignation = $_POST['clientDesignation'];
        $clientTestimonial = $_POST['clientTestimonial'];

        // Validate image
        if (isset($_FILES['clientImage']) && $_FILES['clientImage']['error'] == 0) {
            $imageTmpPath = $_FILES['clientImage']['tmp_name'];
            $imageName = $_FILES['clientImage']['name'];
            $imageSize = $_FILES['clientImage']['size'];
            $imageType = $_FILES['clientImage']['type'];

            // Check if image type is allowed
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageType, $allowedTypes)) {
                die("Invalid image type. Only JPG, PNG, and GIF are allowed.");
            }

            // Set destination path for image
            $destinationPath = 'uploads/' . uniqid() . '_' . basename($imageName);

            // Move image to uploads folder
            if (move_uploaded_file($imageTmpPath, $destinationPath)) {
                // Insert testimonial data into the database
                $stmt = $conn->prepare("INSERT INTO client_testimonials (image, name, designation, testimonial) VALUES (?, ?, ?, ?)");
                $stmt->execute([$destinationPath, $clientName, $clientDesignation, $clientTestimonial]);

                // Success message
                echo "Testimonial added successfully!";
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Image is required.";
        }
    }

} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
?>
