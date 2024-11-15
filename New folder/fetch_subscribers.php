<?php
require 'db.php';

$stmt = $conn->prepare("SELECT * FROM newsletter_subscribers");
$stmt->execute();
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($subscribers);
?>
