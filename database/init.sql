CREATE DATABASE IF NOT EXISTS tastybook_db;
USE tastybook_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    prep_time INT DEFAULT 0,
    cook_time INT DEFAULT 0,
    servings INT DEFAULT 0,
    category VARCHAR(100) NOT NULL,
    img_url TEXT,
    instructions TEXT NOT NULL,
    ingredients TEXT NOT NULL,
    nutrition_calories VARCHAR(50),
    nutrition_protein VARCHAR(50),
    nutrition_carbs VARCHAR(50),
    nutrition_fat VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);
