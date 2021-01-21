<?php
/**
 *  Author:Zhiping Yu, Student number : 000822513  October 3, 2020
 *  This file is used to connect to the database
 */
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=000822513",
        "000822513",
        "19900805"
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
