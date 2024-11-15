document.addEventListener("DOMContentLoaded", () => {
    fetchProjects();
  });
  
  function fetchProjects() {
    fetch('fetch_projects.php') // Adjust the path to the backend file
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        const projectList = document.getElementById("project-list");
        data.forEach(project => {
          const projectCard = document.createElement("div");
          projectCard.classList.add("project");
          projectCard.innerHTML = `
            <img src="${project.image}" alt="${project.name}">
            <h3>${project.name}</h3>
            <p>${project.description}</p>
            <a href="#" class="read-more-btn">Read More</a>
          `;
          projectList.appendChild(projectCard);
        });
      })
      .catch(error => console.error("Error fetching projects:", error));
  }
  


  fetch('fetch_testimonials.php')
    .then(response => response.json())
    .then(data => {
        const testimonialsList = document.getElementById('testimonialsList');
        
        if (data && Array.isArray(data) && data.length > 0) {
            // Loop through each testimonial and display it
            data.forEach(testimonial => {
                const testimonialCard = document.createElement('div');
                testimonialCard.classList.add('testimonialCard');
                testimonialCard.innerHTML = `
                    <img src="${testimonial.image}" alt="${testimonial.name}" class="testimonial-image" />
                    <h3>${testimonial.name}</h3>
                    <p class="testimonial-designation">${testimonial.designation}</p>
                    <p class="testimonial-text">${testimonial.testimonial}</p>
                `;
                testimonialsList.appendChild(testimonialCard);
            });
        } else {
            testimonialsList.innerHTML = '<p>No testimonials available.</p>';
        }
    })
    .catch(error => {
        console.error('Error fetching testimonials:', error);
    });


  document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const fullName = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const mobileNumber = document.getElementById("mobileNumber").value;
    const city = document.getElementById("city").value;
  
    fetch("submit_contact.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        full_name: fullName,
        email: email,
        mobile_number: mobileNumber,
        city: city,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("responseMessage").textContent = data.message;
          document.getElementById("contactForm").reset();
        } else {
          document.getElementById("responseMessage").textContent = data.error || "An error occurred.";
        }
      })
      .catch((error) => {
        document.getElementById("responseMessage").textContent = "An error occurred: " + error.message;
      });
  });
  

  // Handle form submission to subscribe to newsletter
document.getElementById('subscribeForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const email = document.getElementById('email').value;

  // Send the email to the backend for subscription
  fetch('subscribe_email.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'email=' + encodeURIComponent(email),
  })
  .then(response => response.json())
  .then(data => {
      const responseMessage = document.getElementById('responseMessage');
      if (data.success) {
          responseMessage.textContent = 'Thank you for subscribing!';
          responseMessage.style.color = 'green';
      } else {
          responseMessage.textContent = 'An error occurred. Please try again.';
          responseMessage.style.color = 'red';
      }
  })
  .catch(error => {
      console.error('Error:', error);
      document.getElementById('responseMessage').textContent = 'Error subscribing. Please try again later.';
  });
});