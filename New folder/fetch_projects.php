<?php
require 'db.php';

$stmt = $conn->prepare("SELECT * FROM projects");
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($projects);
?>
