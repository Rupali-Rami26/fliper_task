<?php
require 'db.php';

$stmt = $conn->prepare("SELECT * FROM contacts");
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($contacts);
?>
