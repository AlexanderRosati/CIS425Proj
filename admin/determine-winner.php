<?php
    # using the horrendous start_session() function
    session_start();

    # not logged in
    if (!isset($_SESSION['user'])) {
        echo '<script>alert(\'You are not logged in\');window.location = \'login.php\';</script>';
    }

    # not end of application period
    if (!file_exists('../data/winners.xml')) {
        echo '<script>alert(\'Application period is not over\');window.location = \'end-period.php\';</script>';
    }

    # get data on winner
    $winner = simplexml_load_file('../data/winners.xml');

    # winner already determined
    if (!isset($winner->winner[1])) {
        echo '<script>alert(\'Winner already determined\');window.location = \'results.php\';</script>';
    }

    # include displayApplicantInfo function
    include('display_applicant_info.php');
?>
<html lang="en">
    <head>
        <title>Determine Winner</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="determine-winner.css">
        <link rel="stylesheet" href="back-to-form.css">
    </head>
    <body>
        <div id="content">
            <h2>Pick the Winner</h2>
            <?php
                    displayApplicantInfo($winner->winner[0]);
            ?>
            <form action="update-xml.php" method="POST">
                <input type="submit" name="submit" value="Pick <?php echo $winner->winner[0]->fname . ' ' . $winner->winner[0]->lname; ?>">
                <input type="hidden" name="id" value="<?php echo $winner->winner[0]->id; ?>">
                <input type="hidden" name="status" value="<?php echo $winner->winner[0]->status; ?>">
                <input type="hidden" name="cgpa" value="<?php echo $winner->winner[0]->cgpa; ?>">
                <input type="hidden" name="gender" value="<?php echo $winner->winner[0]->gender; ?>">
                <input type="hidden" name="fname_win" value="<?php echo $winner->winner[0]->fname; ?>">
                <input type="hidden" name="lname_win" value="<?php echo $winner->winner[0]->lname; ?>">
                <input type="hidden" name="fname_lose" value="<?php echo $winner->winner[1]->fname; ?>">
                <input type="hidden" name="lname_lose" value="<?php echo $winner->winner[1]->lname; ?>">
                <input type="hidden" name="phoneNum" value="<?php echo $winner->winner[0]->phoneNum; ?>">
                <input type="hidden" name="email_win" value="<?php echo $winner->winner[0]->email; ?>">
                <input type="hidden" name="email_lose" value="<?php echo $winner->winner[0]->email; ?>">
                <input type="hidden" name="dob" value="<?php echo $winner->winner[0]->dob; ?>">
                <input type="hidden" name="creditHours" value="<?php echo $winner->winner[0]->creditHours; ?>">
            </form>    
            <?php
                    displayApplicantInfo($winner->winner[1]);
            ?>
            <form action="update-xml.php" method="POST">
                <input type="submit" name="submit" value="Pick <?php echo $winner->winner[1]->fname . ' ' . $winner->winner[1]->lname; ?>">
                <input type="hidden" name="id" value="<?php echo $winner->winner[1]->id; ?>">
                <input type="hidden" name="status" value="<?php echo $winner->winner[1]->status; ?>">
                <input type="hidden" name="cgpa" value="<?php echo $winner->winner[1]->cgpa; ?>">
                <input type="hidden" name="gender" value="<?php echo $winner->winner[1]->gender; ?>">
                <input type="hidden" name="fname_win" value="<?php echo $winner->winner[1]->fname; ?>">
                <input type="hidden" name="lname_win" value="<?php echo $winner->winner[1]->lname; ?>">
                <input type="hidden" name="fname_lose" value="<?php echo $winner->winner[0]->fname; ?>">
                <input type="hidden" name="lname_lose" value="<?php echo $winner->winner[0]->lname; ?>">
                <input type="hidden" name="phoneNum" value="<?php echo $winner->winner[1]->phoneNum; ?>">
                <input type="hidden" name="email_win" value="<?php echo $winner->winner[1]->email; ?>">
                <input type="hidden" name="email_lose" value="<?php echo $winner->winner[0]->email; ?>">
                <input type="hidden" name="dob" value="<?php echo $winner->winner[1]->dob; ?>">
                <input type="hidden" name="creditHours" value="<?php echo $winner->winner[1]->creditHours; ?>">
            </form>
        </div>
<?php include('back-to-form.php'); ?>