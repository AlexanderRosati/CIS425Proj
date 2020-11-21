<?php
    // connect to database
    $host = 'localhost';
    $user = 'alex';
    $password = '1234';
    $dbname = 'bstsmartscholarshipdb';

    // set dsn
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

    // create connection
    $conn = new PDO($dsn, $user, $password);
?>