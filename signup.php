<?php
header("Content-Type: application/json");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit();
}

// Extract user data
$username = trim($data["username"]);
$email = trim($data["email"]);
$password = trim($data["password"]);

// Validate input
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit();
}

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// JSON file path
$jsonFile = "users.json";

// Load existing users
$users = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Check if email already exists
foreach ($users as $user) {
    if ($user["email"] === $email) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit();
    }
}

// Add new user
$users[] = [
    "username" => $username,
    "email" => $email,
    "password" => $hashedPassword
];

// Save to JSON file
if (file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT))) {
    echo json_encode(["success" => true, "message" => "User registered successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error saving user data"]);
}
?>
