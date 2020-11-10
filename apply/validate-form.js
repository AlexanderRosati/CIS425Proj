//short cut function
let $ = function(id) {
    return document.getElementById(id);
};

// create error msg on page
let errorMsg = function(msg) {
    let errMsg = '<p class="err">' + msg + '</p>';
    $('client_err').innerHTML = errMsg;
};

// do client side validation
let validateForm = function() {
    // get form
    let form = $('app-form');

    // get input
    let studentId = $('stud_id').value; // get student id
    let firstName = $('fname').value; // get first name
    let lastName = $('lname').value; // get last name
    let phoneNum = $('phone').value; // get phone number
    let email = $('email').value; // get email
    let dob = $('dob').value; // get dob
    let cgpa = $('cgpa').value; // get cgpa
    let crdtHrs = $('crdt_hrs').value; // get number of credit hours

    // regular expressions
    let regExpNames = /^[a-zA-Z]{2,30}$/; // regular expression for first and last name
    let regExpPhone = /^[2-9]\d{2}-\d{3}-\d{4}$/; // regular expression for phone number
    let regExpEmail = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i // regular expression for email
    let regExpDOB = /^\d{4}-\d{2}-\d{2}$/; // regular expression for DOB
    let regExpCGPA = /^\d.\d\d$/; // regular expression for CGPA

    // if student ID is empty
    if (studentId === "") {
        errorMsg('Student ID is required.');
    }
    //if first name is empty
    else if (firstName === "") {
        errorMsg('First Name is required.');
    }
    // if last name is empty
    else if (lastName === "") {
        errorMsg('Last Name is required.');
    }
    // if phone number is empty
    else if (phoneNum === "") {
        errorMsg('Phone Number is required.');
    }
    // if email is empty
    else if (email === "") {
        errorMsg('Email is required.');
    }
    // if DOB is empty
    else if (dob === "") {
        errorMsg('Date of Birth is required.');
    }
    // if cgpa is empty
    else if (cgpa === "") {
        errorMsg('CGPA is required.');
    }
    // if credit hours is empty
    else if (crdtHrs === "") {
        errorMsg('Number of Credit Hours is required.');
    }
    // if student ID is invalid
    else if (isNaN(studentId) || parseInt(studentId) > 999999 || parseInt(studentId) < 100000) {
        errorMsg('Please enter valid student ID.');
    }
    // if first name is invalid
    else if (!regExpNames.test(firstName)) {
        errorMsg('First name is not valid.');
    }
    // if last name is invalid
    else if (!regExpNames.test(lastName)) {
        errorMsg('Last name is not valid.');
    }
    // if phone number is invalid
    else if (!regExpPhone.test(phoneNum)) {
        errorMsg('Phone Number is not valid.');
    }
    // if email is invalid
    else if (!regExpEmail.test(email)) {
        errorMsg('Email is not valid.');
    }
    // if dob is invalid
    else if (!regExpDOB.test(dob)) {
        errorMsg('Date of Birth is not valid.');
    }
    // if cgpa is invalid
    else if (!regExpCGPA.test(cgpa) || parseFloat(cgpa) > 4 || cgpa == '0.00') {
        errorMsg('CGPA is not valid.');
    }
    // if number of credit hours is not valid
    else if (!/\d{1,2}/.test(crdtHrs) || parseInt(crdtHrs) < 1 || parseInt(crdtHrs) > 30) {
        errorMsg('Number of credit hours should be between 1 and 30.');
    }
    //submit form
    else {
        form.submit();
    }
};

// when page loads
window.onload = function() {
    $('submit_btn').onclick = validateForm;
};