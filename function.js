// Show specific section when requested
function showSection(section) {
    alert(`Showing section: ${section}`);
}

// Log out user and hide the dashboard
function logout() {
    document.getElementById('user-dashboard').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
}

// Show login and registration forms
document.getElementById('login-button').onclick = function () {
    document.getElementById('login-register-container').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
};

document.getElementById('register-button').onclick = function () {
    document.getElementById('login-register-container').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
};

// Hide forms when "Back" is clicked
document.getElementById('back-button').onclick = function () {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
};

document.getElementById('back-button-reg').onclick = function () {
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
};

// Handle login functionality with fetch to login_form.php
// Login User
document.getElementById('login-submit').onclick = function () {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    fetch("login_form.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    })
        .then(response => response.json().catch(() => ({ status: "error", message: "Invalid JSON response from login_form.php" })))
        .then(data => {
            if (data.status === "success") {
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('user-dashboard').style.display = 'block';
                document.getElementById('username-display').innerText = `Username: ${data.username}`;
                document.getElementById('user-role').innerText = `Role: ${data.role === 'admin' ? 'Admin' : 'Regular User'}`;
                 // Show admin section if user is an admin
                if (data.role === 'admin') {
                    document.getElementById('admin-section').style.display = 'block';
                } else {
                    document.getElementById('admin-section').style.display = 'none';
                }
            } else {
                // Show error message
                document.getElementById('login-error').textContent = data.message;
            }
        })
        .catch(error => console.error("Error:", error));
};


// Handle registration functionality with fetch to register_form.php
// Register User
document.getElementById('register-submit').onclick = function () {
    const name = document.getElementById('register-name').value;
    const username = document.getElementById('register-username').value;
    const email = document.getElementById("register-email").value.trim();
    const password = document.getElementById('register-password').value;

    if (name && username && password) {
        fetch("register_form.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, username, email, password })
        })
            .then(response => response.json().catch(() => ({ status: "error", message: "Invalid JSON response from register_form.php" })))
            .then(data => {
                if (data.status === "success") {
                    alert("User registered successfully!");
                    document.getElementById('register-form').style.display = 'none';
                    document.getElementById('login-register-container').style.display = 'flex';
                } else {
                    document.getElementById('register-error').textContent = data.message;
                }
            })
            .catch(error => console.error("Error:", error));
    } else {
        alert("Please fill in all fields.");
    }
};

