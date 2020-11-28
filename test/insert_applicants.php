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
    if ($_GET['test'] == 6) {
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

    # tie is broken by status
    else if ($_GET['test'] == 3) {
        # insert 1
        insert(100015, 'Y', 'JUNIOR', '3.6', 'M', 'Alex', 'Rosati', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEM GPA is 3.6

        # insert 2
        insert(100009, 'Y', 'SENIOR', '3.6', 'M', 'Joe', 'Biden', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEMGPA is 3.6
    }

    # tie is broken by gender
    else if ($_GET['test'] == 4) {
        # insert 1
        insert(100015, 'Y', 'JUNIOR', '3.6', 'F', 'Alex', 'Rosati', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEM GPA is 3.6

        # insert 2
        insert(100009, 'Y', 'SENIOR', '3.6', 'M', 'Joe', 'Biden', '555-555-5555',
        'smartciscollegestudent@gmail.com', '07-11-1999', 15); # SEMGPA is 3.6
    }

    # testing yougest applicants
    else if ($_GET['test'] == 5) {
        insert(100014, 'Y', 'JUNIOR', '3.4', 'F', 'Jakob', 'Taylor', '555-555-0012', 
        'smartciscollegestudent@gmail.com', '01-01-2000', 15);

        insert(100008, 'Y', 'JUNIOR', '3.4', 'F', 'Alex', 'Rosat', '555-555-0012', 
        'smartciscollegestudent@gmail.com', '01-02-2000', 15);

        insert(100006, 'Y', 'JUNIOR', '3.4', 'F', 'Hillary', 'Clinton', '555-555-0012', 
        'smartciscollegestudent@gmail.com', '02-02-2000', 15);

        insert(100003, 'Y', 'JUNIOR', '3.4', 'F', 'Donald', 'Trump', '555-555-0012', 
        'smartciscollegestudent@gmail.com', '03-02-2000', 15);
    }

    # crazy ass test, like holy fucking cow!
    else if ($_GET['test'] == 7) {
        #insert 1
        insert(100000, 'N', 'FRESHMAN', '3.0', 'M', 'Alexander', 'Rosati', '555-555-0001', 
        'smartciscollegestudent@gmail.com', '07-11-1999', 15);

        #insert 2
        insert(100001, 'N', 'FRESHMAN', '3.0', 'M', 'John', 'Baugh', '555-555-0002', 
        'smartciscollegestudent@gmail.com', '08-13-1999', 15);

        #insert 3
        insert(100002, 'N', 'FRESHMAN', '3.0', 'M', 'Jie', 'Shen', '555-555-0003', 'smartciscollegestudent@gmail.com',
        '06-22-1999', 15);

        #insert 4
        insert(100003, 'N', 'FRESHMAN', '3.1', 'M', 'Bruce', 'Maxim', '555-555-0004', 
        'smartciscollegestudent@gmail.com', '12-05-1999', 15);

        #insert 5
        insert(100004, 'N', 'FRESHMAN', '3.1', 'M', 'Jinhua', 'Guo', '555-555-0005',
        'smartciscollegestudent@gmail.com', '12-05-1999', 15);

        #insert 6
        insert(100005, 'Y', 'SOPHMORE', '3.2', 'M', 'Thomas', 'Steiner', '555-555-0006',
        'smartciscollegestudent@gmail.com', '11-18-1999', 12);

        #insert 7
        insert(100006, 'Y', 'SOPHMORE', '3.2', 'M', 'Shengquang', 'Wang', '555-555-0007',
        'smartciscollegestudent@gmail.com', '01-01-1999', 18);

        #insert 8
        insert(100007, 'Y', 'SOPHMORE', '3.3', 'M', 'Noam', 'Chomsky', '555-555-0008',
        'smartciscollegestudent@gmail.com', '04-02-1999', 15);

        #insert 9
        insert(100008, 'Y', 'SOPHMORE', '3.3', 'M', 'Eugene', 'Debs', '555-555-0009',
        'smartciscollegestudent@gmail.com', '04-01-2000', 13);

        #insert 10
        insert(100009, 'Y', 'SOPHMORE', '3.4', 'M', 'Mother', 'Jones', '555-555-0010',
        'smartciscollegestudent@gmail.com', '03-10-2000', 12);

        #insert 11
        insert(100010, 'Y', 'JUNIOR', '3.4', 'F', 'Bruce', 'Elenbogen', '555-555-0011', 
        'smartciscollegestudent@gmail.com', '07-12-2000', 15);

        #insert 12
        insert(100011, 'Y', 'JUNIOR', '3.4', 'F', 'Jakob', 'Taylor', '555-555-0012',
        'smartciscollegestudent@gmail.com', '06-06-2000', 15);

        #insert 13
        insert(100012, 'Y', 'JUNIOR', '3.5', 'F', 'Howard', 'Zinn', '555-555-0013',
        'smartciscollegestudent@gmail.com', '08-02-2000', 12);

        #insert 14
        insert(100013, 'Y', 'JUNIOR', '3.6', 'F', 'Bryan', 'McKenna', '555-555-0014',
        'smartciscollegestudent@gmail.com', '01-05-2000', 12);

        #insert 15
        insert(100014, 'Y', 'JUNIOR', '3.6', 'F', 'Kyle', 'Kulinski', '555-555-0015',
        'smartciscollegestudent@gmail.com', '01-07-2000', 15);

        #insert 16
        insert(100015, 'Y', 'SENIOR', '3.7', 'F', 'Joe', 'Biden', '555-555-0016',
        'smartciscollegestudent@gmail.com', '09-11-2001', 16);

        #insert 17
        insert(100016, 'N', 'SENIOR', '3.7', 'F', 'Sam', 'Seder', '555-555-0017',
        'smartciscollegestudent@gmail.com', '03-06-2001', 10);

        #insert 18
        insert(100017, 'Y', 'SENIOR', '3.7', 'F', 'John', 'Oliver', '555-555-0018',
        'smartciscollegestudent@gmail.com', '02-14-2001', 14);

        #insert 19
        insert(100018, 'Y', 'SENIOR', '3.8', 'F', 'George', 'Carlin', '555-555-0019',
        'smartciscollegestudent@gmail.com', '10-31-2001', 12);

        #insert 20
        insert(100019, 'N', 'SENIOR', '3.9', 'F', 'Brahim', 'Medjahed', '555-555-0020',
        'smartciscollegestudent@gmail.com', '12-25-1945', 12);
    }

    header('Location: ../apply/application.php');
?>