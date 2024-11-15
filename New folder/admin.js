// Show the selected section in the admin panel
function showSection(sectionId) {
  document.querySelectorAll(".admin-section").forEach(section => {
      section.style.display = section.id === sectionId ? "block" : "none";
  });
}

// Handle Project Form Submission
document.getElementById("addProjectForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("add_project.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadProjects(); // Reload project list after adding
    })
    .catch(error => console.error("Error:", error));
});

// Function to Load Projects
function loadProjects() {
    fetch("fetch_projects.php")
        .then(response => response.json())
        .then(data => {
            const projectList = document.getElementById("projectList");
            projectList.innerHTML = ""; // Clear previous list
            data.forEach(project => {
                const div = document.createElement("div");
                div.innerHTML = `
                    <div>
                        <h3>${project.name}</h3>
                        <p>${project.description}</p>
                        <img src="${project.image}" alt="${project.name}" style="max-width: 200px;">
                        <button onclick="editProject(${project.id})">Edit</button>
                        <button onclick="deleteProject(${project.id})">Delete</button>
                    </div>
                `;
                projectList.appendChild(div);
            });
        })
        .catch(error => console.error("Error loading projects:", error));
}

// Edit Project Function
function editProject(projectId) {
    // Fetch project details to populate the edit form
    fetch(`fetch_project.php?id=${projectId}`)
        .then(response => response.json())
        .then(data => {
            // Populate form with project data
            document.querySelector('input[name="name"]').value = data.name;
            document.querySelector('textarea[name="description"]').value = data.description;
            document.getElementById("croppedImage").value = data.image;
            document.getElementById("imagePreview").src = data.image;

            // Change form submit action to update
            const form = document.getElementById("addProjectForm");
            form.onsubmit = function (e) {
                e.preventDefault();
                const updatedFormData = new FormData(form);
                updatedFormData.append('id', projectId);
                fetch("update_project.php", {
                    method: "POST",
                    body: updatedFormData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    loadProjects(); // Reload project list
                })
                .catch(error => console.error("Error:", error));
            };
        })
        .catch(error => console.error("Error fetching project:", error));
}

// Delete Project Function
function deleteProject(projectId) {
    if (confirm("Are you sure you want to delete this project?")) {
        fetch(`delete_project.php?id=${projectId}`, {
            method: "GET"
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadProjects(); // Reload project list after deletion
        })
        .catch(error => console.error("Error:", error));
    }
}

// Load projects when page loads
loadProjects();


fetch('fetch_testimonials.php')
.then(response => response.json())
.then(data => {
    const testimonialsList = document.getElementById('testimonialsList');
    data.forEach(testimonial => {
        const testimonialCard = document.createElement('div');
        testimonialCard.classList.add('testimonialCard');
        testimonialCard.innerHTML = `
            <img src="${testimonial.image}" alt="${testimonial.name}" />
            <h3>${testimonial.name}</h3>
            <p class="designation">${testimonial.designation}</p>
            <p>${testimonial.testimonial}</p>
            <button>Edit</button>
            <button>Delete</button>
        `;
        testimonialsList.appendChild(testimonialCard);
    });
})
.catch(error => console.error('Error:', error));


/// Example to fetch contact details from backend and display in table
fetch('fetch_contact_details.php')
.then(response => response.json())
.then(data => {
    const contactTableBody = document.getElementById('contactTableBody');
    contactTableBody.innerHTML = ''; // Clear any previous content

    data.forEach(contact => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${contact.full_name}</td>
            <td>${contact.email}</td>
            <td>${contact.mobile}</td>
            <td>${contact.city}</td>
        `;
        contactTableBody.appendChild(row);
    });
})
.catch(error => console.error('Error:', error));

// Fetch and display newsletter subscribers
fetch("fetch_subscribers.php")
  .then(response => response.json())
  .then(data => {
      const subscriberList = document.getElementById("subscriberList");
      data.forEach(subscriber => {
          const div = document.createElement("div");
          div.innerHTML = `<p>${subscriber.email}</p>`;
          subscriberList.appendChild(div);
      });
  });


  