<?php
    # use the ridiculously stupid session_start() function
    session_start();

    # not logged in
    if (!isset($_SESSION['user'])) {
        echo '<script>alert(\'You are not logged in\');window.location = \'login.php\';</script>';
    }

    # logged in but period isn't over
    if (!file_exists('../data/winners.xml')) {
        echo '<script>alert(\'Application period is not over\');window.location = \'end-period.php\';</script>';
    }

    # get data on winner
    $winner = simplexml_load_file('../data/winners.xml');
    $winner = $winner->winner[0];
?>

<html lang="en">
    <head>
        <title>Results</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>The Winner is <?php echo $winner->fname . ' ' . $winner->lname; ?>!</h2>
        <?php
            # display winners information
            include('display_applicant_info.php');
            displayApplicantInfo($winner);
        ?>
        <form action="delete_winners.php" method="POST">
            <input type="submit" name="submit" value="Begin New Application Period">
        </form>
    </body>
</html>