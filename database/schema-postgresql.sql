-- Athletic Trainer Database Schema for PostgreSQL
-- This file contains the PostgreSQL-specific database structure

-- Create database (run this separately as superuser if needed)
-- CREATE DATABASE athleticdb WITH ENCODING 'UTF8' LC_COLLATE='en_US.UTF-8' LC_CTYPE='en_US.UTF-8';

-- Connect to the database
\c athleticdb;

-- Drop tables if they exist (for clean reinstall)
DROP TABLE IF EXISTS application_logs CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS diagnostic CASCADE;
DROP TABLE IF EXISTS injury CASCADE;

-- Injury table
CREATE TABLE injury (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    page_url VARCHAR(255),
    severity VARCHAR(50),
    treatment TEXT,
    symptoms TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create index on name column
CREATE INDEX idx_injury_name ON injury(name);

-- Diagnostic table
CREATE TABLE diagnostic (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    body_part VARCHAR(100),
    description TEXT,
    symptoms TEXT,
    severity VARCHAR(50),
    treatment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes
CREATE INDEX idx_diagnostic_name ON diagnostic(name);
CREATE INDEX idx_diagnostic_body_part ON diagnostic(body_part);

-- Sample data for injury table
INSERT INTO injury (name, description, page_url, severity, treatment, symptoms) VALUES
('Ankle Sprain', 'A sprain occurs when ligaments are stretched or torn', 'ankle.php', 'Variable (3 degrees)', 'Rest, Ice, Compression, Elevation', 'Immediate swell and bruising, severe pain, unstable feeling'),
('Tennis Elbow', 'Inflammation of the tendons on the outside of the elbow', 'elbow.php', 'Moderate to Severe', 'Exercises for flexibility and arm muscle strength', 'Pain and tenderness in the bony knob on the outside of elbow'),
('Groin Pull', 'A strain of the adductor muscles in the groin', 'groin.php', 'Variable (3 degrees)', 'Anti-inflammatory pain killers, Ice, Compression, stretching exercises', 'Pain and tenderness in the groin and inside of thigh'),
('Hamstring Strain', 'Injury to the hamstring muscles in the back of the thigh', 'thighs.php', 'Variable (3 degrees)', 'Ice, Compression, Elevation', 'Sudden severe pain during exercise, pain in back of thigh'),
('ACL Tear', 'Tear of the anterior cruciate ligament in the knee', 'knee.php', 'Severe', 'Rest, Compression, Ice, possible surgery', 'Loud pop, severe pain, loss of range of motion')
ON CONFLICT DO NOTHING;

-- Sample data for diagnostic table
INSERT INTO diagnostic (name, body_part, description, symptoms, severity, treatment) VALUES
('Ankle Sprain', 'Ankle', 'Common injury affecting the ankle ligaments', 'Immediate swell and bruising, severe pain, unstable feeling', 'Variable (3 degrees)', 'Rest, Ice, Compression'),
('Tennis Elbow', 'Elbow', 'Overuse injury affecting the elbow tendons', 'Pain and tenderness in elbow, radiating pain', 'Moderate to Severe', 'Exercises for flexibility and strength'),
('Groin Pull', 'Groin', 'Strain of the groin muscles', 'Pain in groin and inner thigh, pain when bringing legs together', 'Variable (3 degrees)', 'Anti-inflammatory medication, Ice, Compression, stretching'),
('Hamstring Strain', 'Thighs', 'Injury to hamstring muscles', 'Sudden pain during exercise, tenderness, bruising', 'Variable (3 degrees)', 'Ice, Compression, Elevation'),
('ACL Tear', 'Knee', 'Tear of knee ligament', 'Popping sensation, severe pain, swelling, instability', 'Severe', 'Rest, Compression, Ice, medical evaluation')
ON CONFLICT DO NOTHING;

-- Optional: Create a sessions table for database-backed sessions
CREATE TABLE sessions (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    data TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

CREATE INDEX idx_sessions_last_activity ON sessions(last_activity);

-- Optional: Create a logs table for application logging
CREATE TABLE application_logs (
    id SERIAL PRIMARY KEY,
    level VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    context TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_logs_level ON application_logs(level);
CREATE INDEX idx_logs_created_at ON application_logs(created_at);

-- Create function to update updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create triggers for updated_at
CREATE TRIGGER update_injury_updated_at BEFORE UPDATE ON injury
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_diagnostic_updated_at BEFORE UPDATE ON diagnostic
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Display table information
\dt
\d injury
\d diagnostic

-- Show sample data
SELECT 'Injury table count:' as info, COUNT(*) as count FROM injury;
SELECT 'Diagnostic table count:' as info, COUNT(*) as count FROM diagnostic;
