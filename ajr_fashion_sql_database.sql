CREATE DATABASE ajr_fashion;
USE ajr_fashion;

-- Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    stock INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Users Table (Added is_admin column)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0, -- 1 for admin, 0 for regular user
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10, 2),
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order Items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Reviews Table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample Data
INSERT INTO categories (name) VALUES ('Men'), ('Women'), ('Kids');
INSERT INTO products (name, description, price, category_id, image_url, stock) VALUES
('Casual Shirt', 'Comfortable cotton shirt for everyday wear.', 29.99, 1, 'images/shirt.jpg', 100),
('Summer Dress', 'Light and breezy dress for summer vibes.', 49.99, 2, 'images/dress.jpg', 50),
('Kids Jacket', 'Warm jacket for kids.', 39.99, 3, 'images/jacket.jpg', 75);

-- Sample Admin User (password: admin123)
INSERT INTO users (username, email, password, is_admin) VALUES
('admin', 'admin@ajrfashion.com', '$2y$10$VHEE8DM.h/P8EPWJ7uobBOpJ/iNYeGxvwUmjvB2a7xHupKRIIZPri', 1);