<?php if (isset($_POST['submit'])) { # if submitted to

# get values from form
$id = $_POST['id'];
$status = $_POST['status'];
$cgpa = $_POST['cgpa'];
$gender = $_POST['gender'];
$fname_win = $_POST['fname_win'];
$lname_win = $_POST['lname_win'];
$fname_lose = $_POST['fname_lose'];
$lname_lose = $_POST['lname_lose'];
$phoneNum = $_POST['phoneNum'];
$email_win = $_POST['email_win'];
$dob = $_POST['dob'];
$credit_hours = $_POST['creditHours'];
$email_lose = $_POST['email_lose'];

# create xml file
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<winners>
	<winner>
		<id>$id</id>
		<status>$status</status>
		<cgpa>$cgpa</cgpa>
		<gender>$gender</gender>
		<fname>$fname_win</fname>
		<lname>$lname_win</lname>
		<phoneNum>$phoneNum</phoneNum>
		<email>$email_win</email>
		<dob>$dob</dob>
		<creditHours>$credit_hours</creditHours>
	</winner>
</winners>
XML;

# delete old xml file
unlink('../data/winners.xml');

# create file handler
$fileHandler = fopen('../data/winners.xml', 'w');

# write to file
fwrite($fileHandler, $xml);

# close file handler
fclose($fileHandler);

# email loser
$fullname_lose = $fname_lose . ' ' . $lname_lose;
$loser_email_body = "";
$loser_email_body .= "Hi $fullname_lose,\n\n";
$loser_email_body .= "You didn't win the B. S. T. Smart Scholarship.\n\n";
$loser_email_body .= "Try harder next time!";

# try to email loser
if (!mail($email_lose, "So Sorry, $fullname_lose", $loser_email_body)) {
    echo 'didn\'t send email :(';
    exit();
}

# include database
include('../database.php');

# get tuition paid
$tuition = $conn->query('SELECT TUITION FROM STUDENTS WHERE ID=' . $id, PDO::FETCH_OBJ);
$tuition = $tuition->fetch();
$tuition = $tuition->TUITION;

# insert into awarded table
$insert = "INSERT INTO AWARDED (ID, AMOUNT_AWARDED, FULL_NAME)";
$insert .= "VALUES ($id, '$tuition', '$fname_win $lname_win')";
$conn->query($insert);

# email winner
$winner_email_body = "";
$winner_email_body .= "Hi $fname_win $lname_win,\n\n";
$winner_email_body .= "You won the B. S. T. Smart Scholarship! Congratulations! ";
$winner_email_body .= "You will be reimbursed for tuition this semester, a total of ";
$winner_email_body .= "$$tuition! Amazing!!!\n\n";
$winner_email_body .= "Have an amazing rest of your day!!!!";

# email winner
if (!mail($email_win, 'You Won the B. S. T. Smart Scholarship!', $winner_email_body)) {
    echo 'Email to winner didn\'t send :(';
    exit();
}

# email for accounting department
$accounting_email = "";
$accounting_email .= "Hi Emma, Head of the Accounting Department,\n\n";
$accounting_email .= "$fname_win $lname_win won the B. S. T. Smart Scholarship this semester. ";
$accounting_email .= "Please reimburse him/her $$tuition for this semester.\n\n";
$accounting_email .= "Thanks.\n\n";
$accounting_email .= "Regards,\n\n\n";
$accounting_email .= "Committe for B. S. T. Smart Scholarship";

# email account office
if (!mail('smartciscollegestudent@gmail.com', 'Reimbursement for Student', $accounting_email)) {
    echo 'Account Email didnt send :(';
    exit();
}

# go to results page
header('Location: results.php');
exit();

} # end if

else { # otherwise
$html = <<<HTML
<iframe width="560" height="315" src="https://www.youtube.com/embed/My0lzMuNcHI" frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen></iframe>
HTML;

echo $html;
} # end else

?>