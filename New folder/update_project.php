<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $croppedImage = $_POST['croppedImage'];

    // Decode Base64 image
    $imageData = str_replace('data:image/jpeg;base64,', '', $croppedImage);
    $imageData = base64_decode($imageData);

    // Save image on the server
    $imagePath = 'uploads/' . uniqid() . '.jpg';
    file_put_contents($imagePath, $imageData);

    // Update project details in the database
    $stmt = $conn->prepare("UPDATE projects SET name = :name, description = :description, image = :image WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Project updated successfully"]);
}
?>
