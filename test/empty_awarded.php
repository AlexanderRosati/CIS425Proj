<?php
    # get access to database
    include('../database.php');

    # delete everything in awarded
    $conn->query('DELETE FROM AWARDED');

    # go back to form
    header('Location: ../apply/application.php');
    exit();
?>