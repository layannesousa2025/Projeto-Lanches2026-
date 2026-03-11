-- database.sql
-- Run this script in your MySQL client (like phpMyAdmin) to create the database and tables.

CREATE DATABASE IF NOT EXISTS hero_burgers;
USE hero_burgers;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    reset_token VARCHAR(20) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default admin account (Password is 'admin123')
-- We use a pre-calculated bcrypt hash for 'admin123'
INSERT IGNORE INTO users (name, email, password, role) VALUES 
('Administrador', 'admin@hero.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'admin'),
('Lay', 'Laysousa@gmail.com', '$2y$10$c9fR8r3TmT4dPrQs5N6jdujl6Lx9FEvQFo1vAs0Vte.xHY8GL5QXy', 'user');
