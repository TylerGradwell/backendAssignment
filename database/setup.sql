--Start of my code documentation. Here I create my tables following my ER setup

CREATE DATABASE st_alphonsus_school;
USE st_alphonsus_school;
CREATE TABLE classes (
    class_id INT PRIMARY KEY AUTO_INCREMENT,
    class_name VARCHAR(50) NOT NULL,
    year_group INT NOT NULL,
    capacity INT NOT NULL
);
CREATE TABLE teacher (
    teacher_id INT PRIMARY KEY AUTO_INCREMENT,
    class_id INT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    employment_start_date DATE NOT NULL,
    specialization VARCHAR(100),
    background_check_date DATE NOT NULL,
    annual_salary DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (class_id) REFERENCES classes(class_id),
    UNIQUE KEY (class_id)
);
CREATE TABLE pupil (
    pupil_id INT PRIMARY KEY AUTO_INCREMENT,
    class_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    address VARCHAR(255) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    medical_info TEXT,
    enrollment_date DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);
CREATE TABLE parent_guardian (
    parent_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    relationship_to_pupil VARCHAR(50),
    address VARCHAR(255) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    primary_contact BOOLEAN NOT NULL
);
CREATE TABLE pupil_parent (
    pupil_parent_id INT PRIMARY KEY AUTO_INCREMENT,
    pupil_id INT NOT NULL,
    parent_id INT NOT NULL,
    FOREIGN KEY (pupil_id) REFERENCES pupil(pupil_id),
    FOREIGN KEY (parent_id) REFERENCES parent_guardian(parent_id)
);
CREATE TABLE library_book (
    book_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    isbn VARCHAR(50) NOT NULL,
    category VARCHAR(50),
    available BOOLEAN NOT NULL
);
CREATE TABLE library_loan (
    loan_id INT PRIMARY KEY AUTO_INCREMENT,
    pupil_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (pupil_id) REFERENCES pupil(pupil_id),
    FOREIGN KEY (book_id) REFERENCES library_book(book_id)
);
CREATE TABLE dinner_account (
    account_id INT PRIMARY KEY AUTO_INCREMENT,
    pupil_id INT NOT NULL,
    balance DECIMAL(10,2) NOT NULL,
    meal_preference VARCHAR(50),
    free_school_meals BOOLEAN NOT NULL,
    FOREIGN KEY (pupil_id) REFERENCES pupil(pupil_id)
);
CREATE TABLE dinner_payment (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    term VARCHAR(50),
    FOREIGN KEY (account_id) REFERENCES dinner_account(account_id)
);
CREATE TABLE salary (
    salary_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT NOT NULL,
    annual_amount DECIMAL(10,2) NOT NULL,
    pay_scale VARCHAR(50),
    effective_from DATE NOT NULL,
    effective_to DATE,
    FOREIGN KEY (teacher_id) REFERENCES teacher(teacher_id)
);
CREATE TABLE attendance (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    pupil_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    session VARCHAR(50),
    status VARCHAR(50) NOT NULL,
    notes TEXT,
    FOREIGN KEY (pupil_id) REFERENCES pupil(pupil_id)
);
CREATE TABLE teacher_user (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(50),
    last_login DATETIME,
    is_active BOOLEAN NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teacher(teacher_id),
    UNIQUE KEY (teacher_id)
);
CREATE TABLE parent_user (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    parent_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(50),
    last_login DATETIME,
    is_active BOOLEAN NOT NULL,
    FOREIGN KEY (parent_id) REFERENCES parent_guardian(parent_id),
    UNIQUE KEY (parent_id)
);
--end of my code I wrote