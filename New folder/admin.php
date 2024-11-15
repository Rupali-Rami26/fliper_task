<?php
// Database configuration
$host = 'localhost';
$db_name = 'projects_db'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all subscribed emails
    $stmt = $conn->prepare("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
    $stmt->execute();
    $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css">



</head>
<body>
    <h1>Admin Panel</h1>
    <nav>
        <button onclick="showSection('projects')">Projects</button>
        <button onclick="showSection('clients')">Clients</button>
        <button onclick="showSection('contacts')">Contact Form Responses</button>
        <button onclick="showSection('subscribers')">Subscribers</button>
    </nav>

    <!-- Projects Section -->
    <!-- Admin Panel - Manage Projects -->
<section id="projects" class="admin-section">
  <h2>Manage Projects</h2>
  
  <section id="projects" class="admin-section">
    <h2>Manage Projects</h2>
    
    <!-- Form to Add New Project -->
    <form id="addProjectForm">
        <input type="text" name="name" placeholder="Project Name" required>
        <textarea name="description" placeholder="Project Description" required></textarea>
        <input type="file" id="imageInput" accept="image/*" required>
        <div><img id="imagePreview" style="max-width: 100%;"></div>
        <button type="button" id="cropButton">Crop Image</button>
        <input type="hidden" name="croppedImage" id="croppedImage">
        <button type="submit">Add Project</button>
    </form>

    <!-- List of Existing Projects -->
    <div id="projectList"></div>
</section>
</section>


    <!-- Clients Section -->
    <section id="clientTestimonials" class="admin-section">
      <h2>Client Testimonials</h2>
  
      <form id="testimonialForm" action="add_testimonial.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
              <label for="clientImage">Client Image</label>
              <input type="file" id="clientImage" name="clientImage" required />
          </div>
          <div class="form-group">
              <label for="clientName">Client Name</label>
              <input type="text" id="clientName" name="clientName" required />
          </div>
          <div class="form-group">
              <label for="clientDesignation">Designation</label>
              <input type="text" id="clientDesignation" name="clientDesignation" required />
          </div>
          <div class="form-group">
              <label for="clientTestimonial">Testimonial</label>
              <textarea id="clientTestimonial" name="clientTestimonial" required></textarea>
          </div>
          <button type="submit">Add Testimonial</button>
      </form>
  
      <div id="testimonialsList">
          <!-- Dynamic client testimonials will appear here -->
      </div>
  </section>
  

    

    <section id="contactDetails" class="admin-section">
      <h2>Contact Form Details</h2>
      
      <!-- Table to display contact form responses -->
      <table>
          <thead>
              <tr>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Mobile Number</th>
                  <th>City</th>
              </tr>
          </thead>
          <tbody id="contactTableBody">
              <!-- Dynamic rows will be inserted here from backend -->
              <tr>
                  <td>John Doe</td>
                  <td>johndoe@example.com</td>
                  <td>123-456-7890</td>
                  <td>New York</td>
              </tr>
              <!-- More rows will be populated dynamically -->
          </tbody>
      </table>
  </section>
  
  <section id="subscriptions" class="admin-section">
    <h1>Subscribed Emails</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Subscribed At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td><?php echo $subscriber['id']; ?></td>
                    <td><?php echo $subscriber['email']; ?></td>
                    <td><?php echo $subscriber['subscribed_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<script>
    // Fetch subscription data from the backend
    fetch('view_subscriptions.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('subscriptionsTableBody');
            data.forEach(sub => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${sub.id}</td>
                    <td>${sub.email}</td>
                    <td>${sub.subscribed_at}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
</script>

    <script src="admin.js"></script>
    <!-- Cropper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.js"></script>
</body>
</html>
