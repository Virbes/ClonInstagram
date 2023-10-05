DROP DATABASE IF EXISTS laravel_master;
CREATE DATABASE IF NOT EXISTS laravel_master;

USE laravel_master;

CREATE TABLE users(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    role VARCHAR(20),
    name VARCHAR(100),
    surname VARCHAR(200),
    nick VARCHAR(100),
    email VARCHAR(255),
    password VARCHAR(255),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remember_token VARCHAR(255)
)ENGINE=InnoDB;

CREATE TABLE images (
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
    user_id INT,
    image_path VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB;

CREATE TABLE comments (
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT,
    image_id INT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (image_id) REFERENCES images(id)
)ENGINE=InnoDB;

CREATE TABLE likes(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT,
    image_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (image_id) REFERENCES images(id)
)ENGINE=InnoDB;