-- ============================================================
-- PLASTIC POLLUTIONS - Environmental Action Group
-- Database Schema v1.0
-- Pentecost University - PUIS304 Project
-- ============================================================

CREATE DATABASE IF NOT EXISTS plastic_pollution CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE plastic_pollution;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id VARCHAR(8) UNIQUE NOT NULL, -- PU + 6 digits
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_active TINYINT(1) DEFAULT 1,
    login_attempts INT DEFAULT 0,
    locked_until TIMESTAMP NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Login Attempts Table (for tracking failed attempts)
CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    email VARCHAR(150),
    ip_address VARCHAR(45),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success TINYINT(1) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Donations Table
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    donation_type ENUM('one_time', 'monthly') DEFAULT 'one_time',
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Petitions Table
CREATE TABLE petitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    target_signatures INT DEFAULT 1000,
    current_signatures INT DEFAULT 0,
    status ENUM('active', 'completed', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Petition Signatures
CREATE TABLE petition_signatures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    petition_id INT NOT NULL,
    user_id INT NOT NULL,
    signed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (petition_id) REFERENCES petitions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_signature (petition_id, user_id)
);

-- Campaigns Table
CREATE TABLE campaigns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    start_date DATE,
    end_date DATE,
    target_goal TEXT,
    impact_metrics TEXT,
    status ENUM('upcoming', 'active', 'completed') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- News/Blog Table
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    author VARCHAR(100),
    category VARCHAR(50),
    is_published TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contact Messages Table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Visitor Counter Table
CREATE TABLE visitor_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_date DATE NOT NULL,
    page_visits INT DEFAULT 0,
    unique_visitors INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_date (visit_date)
);

-- User Activity Log
CREATE TABLE user_activity (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Environmental Statistics (for animated counters)
CREATE TABLE env_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_name VARCHAR(100) NOT NULL,
    stat_value DECIMAL(15, 2) NOT NULL,
    unit VARCHAR(50),
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
-- SEED DATA
-- ============================================================

-- Insert environmental statistics
INSERT INTO env_stats (stat_name, stat_value, unit, description) VALUES
('Plastic in Oceans', 15000000000, 'tonnes', 'Total plastic waste in oceans worldwide'),
('Recycling Rate', 9, '%', 'Global plastic recycling rate'),
('Marine Life Affected', 700, 'species', 'Marine species affected by plastic pollution'),
('Annual Plastic Production', 400, 'million tonnes', 'Global plastic production per year'),
('Microplastics in Water', 94, '%', 'Percentage of tap water containing microplastics');

-- Insert sample campaigns
INSERT INTO campaigns (title, description, start_date, end_date, target_goal, status) VALUES
('Ban Single-Use Plastics', 'Campaign to ban single-use plastics in Ghana', '2026-01-01', '2026-12-31', 'National policy implementation', 'active'),
('Beach Cleanup Initiative', 'Monthly beach cleanup activities across coastal areas', '2026-03-01', '2026-12-31', '50 beaches cleaned', 'active'),
('Plastic-Free Campus', 'Making Pentecost University plastic-free', '2026-02-01', '2026-12-31', 'Zero single-use plastics on campus', 'active');

-- Insert sample news
INSERT INTO news (title, content, author, category, is_published) VALUES
('New Recycling Center Opens in Accra', 'A state-of-the-art recycling facility has opened in Accra to help manage plastic waste more effectively. The center can process up to 100 tonnes of plastic per month.', 'PlasticPollutions Team', 'News', 1),
('Study Reveals Alarming Microplastic Levels in Fish', 'Recent research shows high levels of microplastics in fish consumed by Ghanaians, raising health concerns.', 'Dr. Kofi Mensah', 'Research', 1),
('Students Lead Plastic-Free Movement', 'University students across Ghana are leading initiatives to reduce plastic usage on campuses.', 'Sarah Osei', 'Community', 1);

-- Insert sample petition
INSERT INTO petitions (title, description, target_signatures) VALUES
('Ban Plastic Bags in Ghana', 'Petition to ban single-use plastic bags in Ghana to reduce environmental pollution and protect marine life.', 5000);

-- Initialize visitor counter
INSERT INTO visitor_stats (visit_date, page_visits, unique_visitors) VALUES
(CURDATE(), 0, 0);
