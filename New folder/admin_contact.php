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

    // Fetch all contact form submissions
    $stmt = $conn->prepare("SELECT * FROM contact_form ORDER BY created_at DESC");
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Contact Form Submissions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

td {
    text-align: center;
}

</style>
<body>

<h1>Contact Form Submissions</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>City</th>
            <th>Submission Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo $contact['id']; ?></td>
                <td><?php echo $contact['full_name']; ?></td>
                <td><?php echo $contact['email']; ?></td>
                <td><?php echo $contact['mobile_number']; ?></td>
                <td><?php echo $contact['city']; ?></td>
                <td><?php echo $contact['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
