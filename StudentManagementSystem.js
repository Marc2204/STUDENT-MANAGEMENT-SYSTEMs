$(document).ready(function() {
    const homeForm = $('#homeclass');
    const addStudentForm = $('#add-class');
    const checklistStudentForm = $('#studentlist');
    const updateStudentForm = $('#update-class');

    // Handle "Check List" button on home screen
    $('button[name="btnCheckList"]').on('click', function(event) {
        event.preventDefault();
        homeForm.fadeOut(300, function() {
            checklistStudentForm.fadeIn(300);
        });
    });

    // Handle "Add Student" button on home screen
    $('button[name="addListStudent"]').on('click', function(event) {
        event.preventDefault();
        homeForm.fadeOut(300, function() {
            addStudentForm.fadeIn(300);
            
        });
    });

    

    // Handle "Check List" button in the Add Student
    $('#checklist').on('click', function(event) {
        event.preventDefault();
        addStudentForm.fadeOut(300, function() {
            checklistStudentForm.fadeIn(300);
        });
    });

    // Handle "Add Student" button in the Student List
    $('#addbutton').on('click', function(event) {
        event.preventDefault();
        checklistStudentForm.fadeOut(300, function() {
            addStudentForm.fadeIn(300);
            
        });
    });

    // Handle "Back to Home" button
    $('.back-home-btn').on('click', function(event) {
        event.preventDefault();
        addStudentForm.add(checklistStudentForm).add(updateStudentForm).fadeOut(300, function() {
            homeForm.fadeIn(300);
        });
    });

    // Function to enable inline editing for a student row
    function enableEdit(studentId) {
        const row = $('#student-row-' + studentId);
        const fullnameCell = row.find('td[data-field="fullname"]');
        const emailCell = row.find('td[data-field="email"]');
        const ageCell = row.find('td[data-field="age"]');
        const classCell = row.find('td[data-field="class"]');

        // Create input fields for editing
        fullnameCell.html(`<input type="text" value="${fullnameCell.text()}" />`);
        emailCell.html(`<input type="email" value="${emailCell.text()}" />`);
        ageCell.html(`<input type="number" value="${ageCell.text()}" />`);
        classCell.html(`<input type="text" value="${classCell.text()}" />`);

        // Change the Edit button to a Save button
        row.find('.update-btn').text('Save').off('click').on('click', function() {
            saveChanges(studentId);
            alert('Student successfully updated');
        });
    }

    // Function to save the changes made
    function saveChanges(studentId) {
        const row = $('#student-row-' + studentId);
        const fullname = row.find('td[data-field="fullname"] input').val();
        const email = row.find('td[data-field="email"] input').val();
        const age = row.find('td[data-field="age"] input').val();
        const className = row.find('td[data-field="class"] input').val();

        // Prepare the data to send to the server
        $.ajax({
            url: 'process_student.php',
            method: 'POST',
            data: {
                'update-student': true,
                'student-id': studentId,
                'fullname': fullname,
                'email': email,
                'age': age,
                'class': className
            },


            success: function(response) {
                console.log(response); // Log the entire response to inspect it
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        // Update the cell content with the new values
                        row.find('td[data-field="fullname"]').text(fullname);
                        row.find('td[data-field="email"]').text(email);
                        row.find('td[data-field="age"]').text(age);
                        row.find('td[data-field="class"]').text(className);
                        
                        // Change the Save button back to Edit
                        row.find('.update-btn').text('Update').off('click').on('click', function() {
                            enableEdit(studentId);
                        });
                    } else {
                        alert('Error updating student: ' + data.message);
                    }
                } catch (error) {
                    alert('Error parsing response: ' + error.message);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }

    // Event listener for update button
    $('.update-btn').on('click', function() {
        const studentId = $(this).closest('tr').data('student-id');
        enableEdit(studentId);
    });
});
