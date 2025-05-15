<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database"; // Replace with your actual database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seed Users Table
    $users = [
        ['John Doe', 'john@example.com', password_hash('password123', PASSWORD_BCRYPT), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
        ['Jane Smith', 'jane@example.com', password_hash('securepass', PASSWORD_BCRYPT), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
    ];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }

    // Seed Products Table
    $products = [
        ['Laptop', 'High-performance laptop', 1200.50, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
        ['Smartphone', 'Latest smartphone with great features', 800.99, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
    ];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute($product);
    }

    echo "Seeding completed successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
