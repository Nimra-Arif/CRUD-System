-- Create the database if it does not exist
CREATE DATABASE IF NOT EXISTS productlookup;

-- Switch to the productlookup database
USE productlookup;

-- Create the admins table
CREATE TABLE IF NOT EXISTS admins (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      username VARCHAR(50) NOT NULL,
                                      password VARCHAR(50) NOT NULL,
                                      role VARCHAR(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS customers (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      username VARCHAR(50) NOT NULL,
                                      password VARCHAR(50) NOT NULL,
                                      role VARCHAR(50) NOT NULL
);

INSERT INTO admins (username, password,role) VALUES ('shahmeer', '1234','admin');

-- Create the products table
CREATE TABLE IF NOT EXISTS products (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        name VARCHAR(50),
                                        price DECIMAL(10, 2),
                                        category VARCHAR(50), -- Corrected typo in 'category'
                                        description VARCHAR(300),
                                        image VARCHAR(255)

);
