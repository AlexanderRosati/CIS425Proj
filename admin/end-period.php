<?php
    # use the ill remembered session_start() function
    session_start();
    
    # if not logged in
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    # include database connection
    include('../database.php');

    # get number of applicants
    $sql = 'SELECT * FROM applicants WHERE ISELIGIBLE=\'Y\'';
    $result = $conn->query($sql);
    $num_applicants = $result->rowCount();  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome, <?php echo $_SESSION['user']; ?>!</title>
        <link rel="stylesheet" href="end-period.css">
    </head>
    <body>
        <main>
            <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
            <p>There are <strong><?php echo $num_applicants; ?></strong> applicant(s). Click below to end
            the current application period. The results will be displayed after you click.</p><br>
            <form method="post" action="process.php">
                <input id="submit" name="submit" type="submit" value="End Application Period">
            </form>
        </main>
    </body>
</html>