-- Create database
CREATE DATABASE IF NOT EXISTS react_crud;

USE react_crud;

-- Create users table
CREATE TABLE IF NOT EXISTS users
(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    email VARCHAR(60),
    mobile BIGINT(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Optionally insert some initial data (if needed)
INSERT INTO users (name, email, mobile) VALUES 
('John Doe', 'john@example.com', 1234567890),
('Jane Smith', 'jane@example.com', 9876543210);

-- Admin123 - RDS
