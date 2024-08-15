CREATE DATABASE complaint_system;

USE complaint_system;

ALTER TABLE users ADD COLUMN role VARCHAR(50) DEFAULT 'user';

UPDATE users SET role = 'admin' WHERE username = 'admin';




CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    complainant_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    complaint_subject VARCHAR(255) NOT NULL,
    complaint_details TEXT NOT NULL,
    complaint_against VARCHAR(255) NOT NULL
     file_path VARCHAR(255)
);
