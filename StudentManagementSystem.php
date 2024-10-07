
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="StudentManagementSystem.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <header class="header">
        <h1>Student Management System</h1>
    </header>

    <div class="container-home" id="homeclass" style="display:block">
        <h1 class="form-title">Choose A Command</h1>
        <form method="post" action="">
            <button type="submit" name="btnCheckList" class="btn-check-list">CHECK LIST</button>
            <button type="button" name="addListStudent" class="add-list-student" id="addListStudentBtn">ADD STUDENT</button>
        </form>
    </div>

    <div class="container" id="add-class" style="display:none">
        <h1 class="form-title">Add Student</h1>
        <form method="post" action="process_student.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fullname" placeholder="Fullname" required>
                <label class="fullname">Fullname</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
                <label class="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="number" name="age" placeholder="Age" required>
                <label class="age">Age</label>
            </div>
            <div class="input-group">
                <i class="fas fa-book"></i>
                <input type="text" name="class" placeholder="Class" required>
                <label class="class">Class</label>
            </div>
            <div class="buttons">
                <input type="submit" class="btn" value="Add Student" name="add-student">
                <input type="button" class="btn-check-list" value="Check list" name="student-list" id="checklist">
            </div>
            <button type="button" class="back-home-btn" id="backToHomeFromAdd">Back to Home</button>
        </form>
    </div>

    <div class="container" id="studentlist" style="display:none">
        <h1 class="form-title">Student List</h1>
        <form method="post" action="">
            <button type="button" class="add-list-student" id="addbutton">Add Student</button>
            <table id="studentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </form>
        <button type="button" class="back-home-btn" id="backToHomeFromList">Back to Home</button>
    </div>

    <script src="StudentManagementSystem.js"></script>
</body>
</html>
