-- Database initialization script for LionDevs Admin Panel
-- Create database (uncomment if needed)
-- CREATE DATABASE liondevs_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE liondevs_portfolio;

-- Projects table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    long_description TEXT,
    image VARCHAR(255),
    technologies JSON,
    features JSON,
    gallery JSON,
    status ENUM('completed', 'in_progress', 'planned', 'cancelled') DEFAULT 'planned',
    date DATE,
    client VARCHAR(255),
    url VARCHAR(255),
    github VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS project_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_key VARCHAR(100) UNIQUE NOT NULL,
    category_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Technologies table
CREATE TABLE IF NOT EXISTS technologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default categories
INSERT IGNORE INTO project_categories (category_key, category_name) VALUES
('Web Development', 'Уеб разработка'),
('Server Administration', 'Сървър администрация'),
('Bot Development', 'Бот разработка'),
('Game Development', 'Игрова разработка'),
('Web Design', 'Уеб дизайн');

-- Insert default technologies
INSERT IGNORE INTO technologies (name) VALUES
('PHP'), ('JavaScript'), ('Python'), ('HTML5'), ('CSS3'), ('MySQL'),
('Node.js'), ('React'), ('Vue.js'), ('Linux'), ('Docker'), ('AWS'),
('MongoDB'), ('Redis'), ('Socket.io'), ('REST APIs'), ('Git'),
('Stripe API'), ('RCON'), ('Discord.py'), ('SQLite'), ('PayPal API');

-- Settings table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123 - change this!)
INSERT IGNORE INTO admin_users (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@liondevs.com');

-- Insert default settings
INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES
('featured_project_id', '');