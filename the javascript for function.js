
const users = [
    { username: "ADMIN1", password: "Password", role: "admin" }
];

function showSection(section) {
    alert(`Showing section: ${section}`);
}

function logout() {
    document.getElementById('user-dashboard').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
}

document.getElementById('login-button').onclick = function() {
    document.getElementById('login-register-container').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
};

document.getElementById('register-button').onclick = function() {
    document.getElementById('login-register-container').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
};

document.getElementById('back-button').onclick = function() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
};

document.getElementById('back-button-reg').onclick = function() {
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-register-container').style.display = 'flex';
};

document.getElementById('login-submit').onclick = function() {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    const user = users.find(u => u.username === username && u.password === password);

    if (user) {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('user-dashboard').style.display = 'block';
        document.getElementById('username-display').innerText = `Username: ${user.username}`;
        document.getElementById('user-role').innerText = `Role: ${user.role === 'admin' ? 'Admin' : 'Regular User'}`;

        if (user.role === 'admin') {
            document.getElementById('admin-section').style.display = 'block';
        }
    } else {
        alert("Invalid credentials");
    }
};

document.getElementById('register-submit').onclick = function() {
    const name = document.getElementById('register-name').value;
    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;

    if (name && username && password) {
        users.push({ username: username, password: password, role: "user" });
        alert("User registered successfully!");
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-register-container').style.display = 'flex';
    } else {
        alert("Please fill in all fields.");
    }
};