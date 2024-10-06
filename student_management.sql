USE student_management;

-- Create Student Table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    age INT,
    class VARCHAR(255) NOT NULL
);

INSERT INTO students (fullname, email, age, class)
VALUES ('Marc Rainier Buitizon', 'marcloyalty@gmail.com', 20, 'CSP107');
      

SELECT*FROM students;
