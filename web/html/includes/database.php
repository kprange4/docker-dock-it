<?php
$db = @mysqli_connect(
    'localhost',
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    'kprange4')
or die('Error connecting to the database');
