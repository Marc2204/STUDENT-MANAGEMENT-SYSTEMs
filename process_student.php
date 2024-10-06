<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'student_management';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "";

    // Add student
    if (isset($_POST['add-student'])) {
        $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($fullname && $email && $age !== false && $class) {
            $stmt = $conn->prepare("INSERT INTO students (fullname, email, age, `class`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $fullname, $email, $age, $class);
            if ($stmt->execute()) {
                $message = "New student added successfully.";
            } else {
                $message = "Error executing statement: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $message = "Error: Please provide valid inputs for all fields.";
        }
        $_SESSION['message'] = $message; 
        header('Location: StudentManagementSystem.php'); 
        exit;
    }

    // Delete student
    if (isset($_POST['delete-student'])) {
        $student_id = filter_input(INPUT_POST, 'student-id', FILTER_VALIDATE_INT);

        if ($student_id) {
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bind_param("i", $student_id);
            if ($stmt->execute()) {
                $message = "Student deleted successfully.";
            } else {
                $message = "Error executing statement: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $message = "Error: Invalid student ID.";
        }
        $_SESSION['message'] = $message;
        header('Location: StudentManagementSystem.php'); 
        exit;
    }

    // Update student
    if (isset($_POST['update-student'])) {
        $student_id = filter_input(INPUT_POST, 'student-id', FILTER_VALIDATE_INT);
        $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Check if all fields are valid
        if ($student_id && $fullname && $email && $age !== false && $class) {
            $stmt = $conn->prepare("UPDATE students SET fullname = ?, email = ?, age = ?, `class` = ? WHERE id = ?");
            if ($stmt === false) {
                echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . htmlspecialchars($conn->error)]);
                exit;
            }

            $stmt->bind_param("ssisi", $fullname, $email, $age, $class, $student_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Execution error: ' . htmlspecialchars($stmt->error)]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        }
        exit; // Stop further execution
    }
}

// Fetch student list for the HTML table
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($student = $result->fetch_assoc()) {
        echo "<tr id='student-row-" . htmlspecialchars($student['id']) . "' data-student-id='" . htmlspecialchars($student['id']) . "'>";
        echo "<td>" . htmlspecialchars($student['id']) . "</td>";
        echo "<td data-field='fullname'>" . htmlspecialchars($student['fullname']) . "</td>";
        echo "<td data-field='email'>" . htmlspecialchars($student['email']) . "</td>";
        echo "<td data-field='age'>" . htmlspecialchars($student['age']) . "</td>";
        echo "<td data-field='class'>" . htmlspecialchars($student['class']) . "</td>";
        echo '<td>
                <form method="post" action="" style="display:inline-block">
                    <input type="hidden" name="student-id" value="' . htmlspecialchars($student['id']) . '">
                    <button type="submit" name="delete-student" class="action-btn delete-btn">Delete</button>
                </form>
                <button type="button" class="action-btn update-btn" onclick="enableEdit(' . htmlspecialchars($student['id']) . ')">Update</button>
              </td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No students available.</td></tr>";
}

$conn->close();
?>
