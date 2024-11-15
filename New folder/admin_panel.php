<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all projects
    $stmt = $conn->prepare("SELECT * FROM projects ORDER BY created_at DESC");
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Projects</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Manage Projects</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Project Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?php echo $project['id']; ?></td>
                <td><?php echo $project['name']; ?></td>
                <td><?php echo $project['description']; ?></td>
                <td><img src="<?php echo $project['image']; ?>" alt="<?php echo $project['name']; ?>" width="100"></td>
                <td>
                    <a href="edit_project.php?id=<?php echo $project['id']; ?>">Edit</a> | 
                    <a href="delete_project.php?id=<?php echo $project['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
