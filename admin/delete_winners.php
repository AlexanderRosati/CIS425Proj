<?php
    # if user subbmitted
    if (isset($_POST['submit'])) {
        # delete xml files
        unlink('../data/winners.xml');

        # go back to form
        header('Location: ../apply/application.php');
    }
    
    else {
        echo '<script>alert(\'Not authorized\');window.location = \'../apply/application.php\';</script>';
    }
?>