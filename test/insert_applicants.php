<?php
    function insert($id, $eligible, $status, $cgpa, $gender, $fname, $lname, $phone_num, $email, $dob, $credit_hours) {
        include('../database.php');
        $insertone = "INSERT INTO APPLICANTS (ID, ISELIGIBLE, STATUS, CUM_GPA, GENDER, FNAME, LNAME, PHONE_NUM, ";
        $insertone .= "EMAIL, DOB, CREDIT_HOURS) VALUES ($id, '$eligible', '$status', '$cgpa', '$gender', ";
        $insertone .= "'$fname', '$lname', '$phone_num', '$email', '$dob', ";
        $insertone .= "$credit_hours)";
        
        $inserted = $conn->query($insertone);

        if (!$inserted) {
            echo 'didnt insert :(';
            exit();
        }
    }

    # one person with highst cpga
    if ($_GET['test'] == 1) {
        #insert 1
        insert(100018, 'Y', 'SENIOR', '3.8', 'F', 'George', 'Carlin', '555-555-0019',
        'smartciscollegestudent@gmail.com', '10-31-2001', 12);

        # insert 2
        insert(100017, 'Y', 'SENIOR', '3.7', 'F', 'John', 'Oliver', '555-555-0018',
        'smartciscollegestudent@gmail.com', '02-14-2001', 14);
    }

    # tie is broken by semester gpa
    else if ($_GET['test'] == 2) {
        # insert 1
        insert(100011, 'Y', 'JUNIOR', '3.4', 'F', 'Jakob', 'Taylor', '555-555-0012', 
        'smartciscollegestudent@gmail.com', '06-06-2000', 15);

        # insert 2
        insert(100010, 'Y', 'JUNIOR', '3.4', 'F', 'Bruce', 'Elenbogen', '555-555-0011', 
        'smartciscollegestudent@gmail.com', '07-12-2000', 15);

        # insert 3
        insert(100009, 'Y', 'SOPHMORE', '3.4', 'M', 'Mother', 'Jones', '555-555-0010', 
        'smartciscollegestudent@gmail.com', '03-10-2000', 12);
    }

    # tire is broken by status
    else if ($_GET['test'] == 3) {
        # insert 1
        insert(100015, 'Y', 'JUNIOR', '3.6', 'M', 'Alex', 'Rosati', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEM GPA is 3.6

        # insert 2
        insert(100009, 'Y', 'SENIOR', '3.6', 'M', 'Joe', 'Biden', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEMGPA is 3.6
    }

    header('Location: ../apply/application.php');
?>