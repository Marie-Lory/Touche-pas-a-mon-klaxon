CREATE DATABASE IF NOT EXISTS covoiturage DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE covoiturage;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(30) DEFAULT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  password_hash VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE agencies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  city VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE trips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  agency_from_id INT NOT NULL,
  agency_to_id INT NOT NULL,
  departure_datetime DATETIME NOT NULL,
  arrival_datetime DATETIME NOT NULL,
  seats_total INT NOT NULL,
  seats_available INT NOT NULL,
  contact_user_id INT NOT NULL,
  created_by_user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (agency_from_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  FOREIGN KEY (agency_to_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  FOREIGN KEY (contact_user_id) REFERENCES users(id) ON DELETE RESTRICT,
  FOREIGN KEY (created_by_user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;
