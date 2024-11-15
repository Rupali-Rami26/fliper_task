<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $croppedImage = $_POST['croppedImage']; // Base64 image data

    // Decode Base64 image
    $imageData = str_replace('data:image/jpeg;base64,', '', $croppedImage);
    $imageData = base64_decode($imageData);

    // Save image on the server
    $imagePath = 'uploads/' . uniqid() . '.jpg';
    file_put_contents($imagePath, $imageData);

    // Insert project into the database
    $stmt = $conn->prepare("INSERT INTO projects (name, description, image) VALUES (:name, :description, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $imagePath);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Project added successfully"]);
}
?>
