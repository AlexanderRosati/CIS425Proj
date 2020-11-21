<?php
    # use the often forgotten 'session_start'
    session_start();

    # make sure user isn't already logged in
    if (isset($_SESSION['user'])) {
        header('Location: end-period.php');
    }

    # set error message to empty string
    $err_msg = '';

    # if form was submitted
    if (isset($_POST['submit'])) {
        # if both fields are filled
        if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
            # get JSON
            $json = file_get_contents('../data/credentials.json');

            # turn JSON into array
            $user_credentials = json_decode($json, true);

            # iterate through user credentials
            foreach ($user_credentials as $cred) {
                # match
                if ($cred['userName'] == $_POST['user_name'] && $cred['password'] == $_POST['password']) {
                    # create session for user name
                    $_SESSION['user'] = $cred['userName'];

                    # go to admin page
                    header('Location: end-period.php');
                }
            }

            $err_msg = 'Either your username or password is incorrect.';
        }

        # if one of the fields isn't filled
        else {
            $err_msg = 'You must fill in both your username and password.';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <h2>Login</h2>
        <?php if($err_msg != ''): ?>
            <p class="err"><?php echo $err_msg; ?></p>
        <?php endif;?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="user_name">Username: </label>
            <input id="user_name" name="user_name" type="text" placeholder="Username"><br>
            <label for="password">Password:</label>
            <input id="password" name="password" type="password" placeholder="Password"><br>
            <label>&nbsp;</label>
            <input id="submit_btn" name="submit" type="submit" value="Submit">
        </form>
    </body>
</html>