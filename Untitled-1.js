document.getElementById("myForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent the form from submitting

  // Get the input values
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const message = document.getElementById("message");

  // Simple Email Pattern
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

  // Validation
  if (username === "" || email === "" || password === "") {
    message.textContent = "All fields are required!";
    message.style.color = "red";
  } else if (!emailPattern.test(email)) {
    message.textContent = "Invalid email format!";
    message.style.color = "red";
  } else if (password.length < 6) {
    message.textContent = "Password must be at least 6 characters!";
    message.style.color = "red";
  } else {
    message.textContent = "Form submitted successfully!";
    message.style.color = "green";
  }
});
