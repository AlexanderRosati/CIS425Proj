<?php
    // if the student hasn't submitted the form
    if (!isset($_POST['submit-form'])) {
        header('Location: application.php');
        exit();
    }

    include('../database.php');

    // make sure student hasn't already applied
    $sql = 'SELECT * FROM APPLICANTS WHERE ID=:id';
    $pre_stmt = $conn->prepare($sql);
    $pre_stmt->execute(['id' => $_POST['stud_id']]);
    
    // already applied
    if ($pre_stmt->rowCount() == 1) {
        include('header.php');
        echo '<main>';
        echo '<h2>You\'ve already applied!!</h2>';
        echo '<p>We will email you the outcome as soon as we know.</p>';
        echo '<br><br><br>';
        echo '</main>';
        exit();
    }

    // close cursor
    $pre_stmt->closeCursor();

    // get data from registration office
    $sql = 'SELECT GENDER, DOB, STATUS, CUM_GPA, CREDIT_HOURS FROM STUDENTS WHERE ID=:id';
    $pre_stmt = $conn->prepare($sql);
    $pre_stmt->execute(['id' => $_POST['stud_id']]);

    // if student id is not found, go back to form and display error message
    if ($pre_stmt->rowCount() === 0) {
        header('Location: application.php?err=stud_id_not_found');
        exit();
    }

    // validate dob
    $date = explode('-', $_POST['dob']);
    $age = date_diff(date_create($_POST['dob']), date_create('now'))->y;

    if (!checkdate($date[1], $date[2], $date[0]) || $age >= 120 || $age < 16) {
        header('Location: application.php?err=invalid_dob');
        exit();
    }

    // get the one record
    $student = $pre_stmt->fetch(PDO::FETCH_OBJ);

    // if student entered wrong gender
    if ($_POST['gender'] != $student->GENDER) {
        header('Location: application.php?err=invalid_gender');
        exit();
    }

    // if student entered wrong dob
    if ($_POST['dob'] != $student->DOB) {
        header('Location: application.php?err=nomatch_dob');
        exit();
    }

    // if student entered wrong status
    if ($_POST['status'] != $student->STATUS) {
        header('Location: application.php?err=nomatch_status');
        exit();
    }

    // if student entered wrong CGPA
    if ($_POST['cgpa'] != $student->CUM_GPA) {
        header('Location: application.php?err=nomatch_cgpa');
        exit();
    }

    // if student enterd wrong number of credit hours
    if ($_POST['crdt_hrs'] != $student->CREDIT_HOURS) {
        header('Location: application.php?err=nomatch_crdt_hrs');
        exit();
    }

    // close cursor
    $pre_stmt->closeCursor();

    // new prepared statement
    $sql = 'INSERT INTO APPLICANTS (ID, ISELIGIBLE, STATUS, CUM_GPA, GENDER, FNAME, LNAME, '
            . 'PHONE_NUM, EMAIL, DOB, CREDIT_HOURS) VALUES (:id, :is_eligible, :status, :cgpa, :gender, '
            . ':fname, :lname, :phone_num, :email, :dob, :credit_hours)';
    $pre_stmt = $conn->prepare($sql);

    // eligible
    if (floatval($student->CUM_GPA) >= 3.2 && $student->CREDIT_HOURS >= 12 && $age <= 23) {
        // insert into applicants table
        $pre_stmt->execute([
            'id' => $_POST['stud_id'], 
            'is_eligible' => 'Y', 
            'status' => $_POST['status'],
            'cgpa' => $_POST['cgpa'],
            'gender' => $_POST['gender'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'phone_num' => $_POST['phone'],
            'email' => $_POST['email'],
            'dob' => $_POST['dob'],
            'credit_hours' => $_POST['crdt_hrs']
        ]);

        // make sure record inserted
        if ($pre_stmt->rowCount() === 0) {
            echo '<p>Insert Failed :(</p>';
            var_dump($pre_stmt);
            exit();
        }
    }
    // not eligible
    else {
        $pre_stmt->execute([
            'id' => $_POST['stud_id'], 
            'is_eligible' => 'N', 
            'status' => $_POST['status'],
            'cgpa' => $_POST['cgpa'],
            'gender' => $_POST['gender'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'phone_num' => $_POST['phone'],
            'email' => $_POST['email'],
            'dob' => $_POST['dob'],
            'credit_hours' => $_POST['crdt_hrs']
        ]);

        // make sure record inserted
        if ($pre_stmt->rowCount() === 0) {
            echo '<p>Insert Failed :(</p>';
            var_dump($pre_stmt);
            exit();
        }

        // create email body
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];

        $email_body = "";
        $email_body .=  "Hi $first_name $last_name,\n\n";
        $email_body .= 'Unfortunately, you did not get the B. S. T. Smart Scholarship ';
        $email_body .= "because you're ineligible.\n\n";
        $email_body .= 'Have a nice day!';

        // send email to ineligible applicant
        if (!mail($_POST['email'], 'About B. S. T. Smart Scholarship', $email_body)) {
            echo '<p>Email did not send :(</p>';
        }
    }
?>
<?php include('header.php'); ?>
<main>
    <h2>Thanks for applying!!</h2>
    <p>We will email you the outcome as soon as we know.</p>
    <br>
    <br>
    <br>
</main>
<footer>
    <ul>    
        <li><a class="footer_nav" href="application.php">Back to Form</a></li>
    </ul>
</footer>

</body>
</html>