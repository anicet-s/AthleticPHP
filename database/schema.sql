-- Athletic Trainer Database Schema
-- This file documents the expected database structure

-- Create database
CREATE DATABASE IF NOT EXISTS athleticdb 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE athleticdb;

-- Injury table
CREATE TABLE IF NOT EXISTS injury (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    page_url VARCHAR(255),
    severity VARCHAR(50),
    treatment TEXT,
    symptoms TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Diagnostic table
CREATE TABLE IF NOT EXISTS diagnostic (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    body_part VARCHAR(100),
    description TEXT,
    symptoms TEXT,
    severity VARCHAR(50),
    treatment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_body_part (body_part)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data for injury table
INSERT INTO injury (name, description, page_url, severity, treatment, symptoms) VALUES
('Ankle Sprain', 'A sprain occurs when ligaments are stretched or torn', 'ankle.php', 'Variable (3 degrees)', 'Rest, Ice, Compression, Elevation', 'Immediate swell and bruising, severe pain, unstable feeling'),
('Tennis Elbow', 'Inflammation of the tendons on the outside of the elbow', 'elbow.php', 'Moderate to Severe', 'Exercises for flexibility and arm muscle strength', 'Pain and tenderness in the bony knob on the outside of elbow'),
('Groin Pull', 'A strain of the adductor muscles in the groin', 'groin.php', 'Variable (3 degrees)', 'Anti-inflammatory pain killers, Ice, Compression, stretching exercises', 'Pain and tenderness in the groin and inside of thigh'),
('Hamstring Strain', 'Injury to the hamstring muscles in the back of the thigh', 'thighs.php', 'Variable (3 degrees)', 'Ice, Compression, Elevation', 'Sudden severe pain during exercise, pain in back of thigh'),
('ACL Tear', 'Tear of the anterior cruciate ligament in the knee', 'knee.php', 'Severe', 'Rest, Compression, Ice, possible surgery', 'Loud pop, severe pain, loss of range of motion')
ON DUPLICATE KEY UPDATE name=name;

-- Sample data for diagnostic table
INSERT INTO diagnostic (name, body_part, description, symptoms, severity, treatment) VALUES
('Ankle Sprain', 'Ankle', 'Common injury affecting the ankle ligaments', 'Immediate swell and bruising, severe pain, unstable feeling', 'Variable (3 degrees)', 'Rest, Ice, Compression'),
('Tennis Elbow', 'Elbow', 'Overuse injury affecting the elbow tendons', 'Pain and tenderness in elbow, radiating pain', 'Moderate to Severe', 'Exercises for flexibility and strength'),
('Groin Pull', 'Groin', 'Strain of the groin muscles', 'Pain in groin and inner thigh, pain when bringing legs together', 'Variable (3 degrees)', 'Anti-inflammatory medication, Ice, Compression, stretching'),
('Hamstring Strain', 'Thighs', 'Injury to hamstring muscles', 'Sudden pain during exercise, tenderness, bruising', 'Variable (3 degrees)', 'Ice, Compression, Elevation'),
('ACL Tear', 'Knee', 'Tear of knee ligament', 'Popping sensation, severe pain, swelling, instability', 'Severe', 'Rest, Compression, Ice, medical evaluation')
ON DUPLICATE KEY UPDATE name=name;

-- Create indexes for better performance
CREATE INDEX idx_injury_name_fulltext ON injury(name);
CREATE INDEX idx_diagnostic_name_fulltext ON diagnostic(name);

-- Optional: Create a sessions table for database-backed sessions
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    data TEXT NOT NULL,
    last_activity INT(10) UNSIGNED NOT NULL,
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Create a logs table for application logging
CREATE TABLE IF NOT EXISTS application_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    context TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_level (level),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Show table structure
SHOW TABLES;
DESCRIBE injury;
DESCRIBE diagnostic;
