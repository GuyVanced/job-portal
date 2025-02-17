-- Create Database
DROP IF EXISTS talentsync; 
CREATE DATABASE IF NOT EXISTS talentsync;
USE talentsync;

-- Users Table (Common for both job seekers and employers)
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('job_seeker', 'employer', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Job Seekers Table
CREATE TABLE job_seekers (
    seeker_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    phone VARCHAR(20),
    location VARCHAR(255),
    skills TEXT,
    education_level VARCHAR(100),
    experience TEXT,
    resume_url VARCHAR(255),  -- Optional CV Upload
    preferred_jobs TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Employers Table
CREATE TABLE employers (
    employer_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(100),
    company_website VARCHAR(255),
    company_description TEXT,
    location VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Jobs Table
CREATE TABLE jobs (
    job_id INT PRIMARY KEY AUTO_INCREMENT,
    employer_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255),
    category VARCHAR(100),
    salary_range VARCHAR(50),
    job_type ENUM('Full-Time', 'Part-Time', 'Contract', 'Internship') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES employers(employer_id) ON DELETE CASCADE
);

-- Applications Table
CREATE TABLE applications (
    application_id INT PRIMARY KEY AUTO_INCREMENT,
    job_id INT NOT NULL,
    seeker_id INT NOT NULL,
    status ENUM('Pending', 'Shortlisted', 'Accepted', 'Rejected') DEFAULT 'Pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE,
    FOREIGN KEY (seeker_id) REFERENCES job_seekers(seeker_id) ON DELETE CASCADE
);

-- Notifications Table
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Admin Table
CREATE TABLE admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    permissions TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Reports Table
CREATE TABLE reports (
    report_id INT PRIMARY KEY AUTO_INCREMENT,
    generated_by INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES admin(admin_id) ON DELETE CASCADE
);
