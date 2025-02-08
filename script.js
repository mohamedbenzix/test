document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let message = document.getElementById("message");

    if (username === "" || email === "" || password === "") {
        message.textContent = "All fields are required!";
        return;
    }

    let userData = {
        username: username,
        email: email,
        password: password
    };

    fetch("signup.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            message.style.color = "green";
            message.textContent = "Sign-up successful!";
        } else {
            message.textContent = data.message;
        }
    })
    .catch(error => {
        message.textContent = "Error: " + error;
    });
});
