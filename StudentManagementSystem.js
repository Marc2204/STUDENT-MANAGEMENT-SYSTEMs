
$(document).ready(function() {
    const homeForm = $('#homeclass');
    const addStudentForm = $('#add-class');
    const checklistStudentForm = $('#studentlist');

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

    // Handle "Check List" button in the Add Student form
    $('#checklist').on('click', function(event) {
        event.preventDefault();
        addStudentForm.fadeOut(300, function() {
            checklistStudentForm.fadeIn(300);
        });
    });

    // Handle "Add Student" button in the Student List section
    $('#addbutton').on('click', function(event) { 
        event.preventDefault();
        checklistStudentForm.fadeOut(300, function() {
            addStudentForm.fadeIn(300);
        });
    });

    // Handle "Back to Home" button
    $('.back-home-btn').on('click', function(event) {
        event.preventDefault();
        addStudentForm.add(checklistStudentForm).fadeOut(300, function() {
            homeForm.fadeIn(300);
        });
    });


    $('.btn').on('click', function(event) {
        event.preventDefault();

       
        alert('Student has been added successfully!');
    });

});
