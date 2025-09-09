CREATE DATABASE registrationDB;

USE registrationDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    address TEXT NOT NULL,
    college VARCHAR(150) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    courses TEXT NOT NULL,
    department VARCHAR(50) NOT NULL,
    programs TEXT NOT NULL,
    startTime TIME NOT NULL,
    endTime TIME NOT NULL,
    fileName VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);