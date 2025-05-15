CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('John Doe', 'john@example.com', 'hashed_password_1', NOW(), NOW()),
('Jane Smith', 'jane@example.com', 'hashed_password_2', NOW(), NOW()),
('Alice Johnson', 'alice@example.com', 'hashed_password_3', NOW(), NOW()),
('Bob Brown', 'bob@example.com', 'hashed_password_4', NOW(), NOW()),
('Charlie Davis', 'charlie@example.com', 'hashed_password_5', NOW(), NOW()),
('Emily White', 'emily@example.com', 'hashed_password_6', NOW(), NOW()),
('Daniel Green', 'daniel@example.com', 'hashed_password_7', NOW(), NOW()),
('Grace Lee', 'grace@example.com', 'hashed_password_8', NOW(), NOW()),
('Henry Martin', 'henry@example.com', 'hashed_password_9', NOW(), NOW()),
('Isabelle Scott', 'isabelle@example.com', 'hashed_password_10', NOW(), NOW()),
('Jake Williams', 'jake@example.com', 'hashed_password_11', NOW(), NOW()),
('Kelly Adams', 'kelly@example.com', 'hashed_password_12', NOW(), NOW()),
('Liam Thompson', 'liam@example.com', 'hashed_password_13', NOW(), NOW()),
('Mia Robinson', 'mia@example.com', 'hashed_password_14', NOW(), NOW()),
('Nathan Walker', 'nathan@example.com', 'hashed_password_15', NOW(), NOW()),
('Olivia Hernandez', 'olivia@example.com', 'hashed_password_16', NOW(), NOW()),
('Peter Ramirez', 'peter@example.com', 'hashed_password_17', NOW(), NOW()),
('Sophia Torres', 'sophia@example.com', 'hashed_password_18', NOW(), NOW()),
('Thomas Jenkins', 'thomas@example.com', 'hashed_password_19', NOW(), NOW()),
('Victoria Evans', 'victoria@example.com', 'hashed_password_20', NOW(), NOW());



INSERT INTO products (name, description, price, created_at, updated_at) VALUES
('Laptop', 'High-performance laptop', 1200.50, NOW(), NOW()),
('Smartphone', 'Latest smartphone with great features', 800.99, NOW(), NOW()),
('Tablet', 'Lightweight tablet with high-resolution display', 450.00, NOW(), NOW()),
('Smartwatch', 'Wearable smartwatch with health tracking', 299.99, NOW(), NOW()),
('Wireless Headphones', 'Noise-canceling wireless headphones', 199.99, NOW(), NOW()),
('Gaming Console', 'Next-gen gaming console', 499.99, NOW(), NOW()),
('Mechanical Keyboard', 'RGB mechanical keyboard', 149.99, NOW(), NOW()),
('Monitor', '4K ultra-wide monitor', 349.99, NOW(), NOW()),
('External Hard Drive', '2TB external hard drive', 129.99, NOW(), NOW()),
('Bluetooth Speaker', 'Portable Bluetooth speaker with deep bass', 99.99, NOW(), NOW()),
('VR Headset', 'Virtual reality headset with motion tracking', 599.99, NOW(), NOW()),
('Camera', 'Professional-grade DSLR camera', 899.99, NOW(), NOW()),
('Drone', 'Quadcopter drone with HD camera', 799.99, NOW(), NOW()),
('Fitness Tracker', 'Activity tracker with heart rate monitoring', 149.99, NOW(), NOW()),
('Wireless Mouse', 'Ergonomic wireless mouse', 49.99, NOW(), NOW()),
('Power Bank', 'High-capacity power bank', 79.99, NOW(), NOW()),
('Smart TV', 'Ultra-HD Smart TV with streaming apps', 999.99, NOW(), NOW()),
('Electric Scooter', 'Lightweight electric scooter', 450.00, NOW(), NOW()),
('Gaming Chair', 'Ergonomic gaming chair with lumbar support', 250.00, NOW(), NOW()),
('Microphone', 'Studio-quality condenser microphone', 199.99, NOW(), NOW());
