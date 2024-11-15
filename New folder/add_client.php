<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Save image to the 'uploads' directory
    $imagePath = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Insert client into the database
    $stmt = $conn->prepare("INSERT INTO clients (name, designation, description, image) VALUES (:name, :designation, :description, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':designation', $designation);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $imagePath);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Client added successfully"]);
}
?>
