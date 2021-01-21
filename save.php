<!DOCTYPE html>
<?php
include "connect.php";
$result = filter_input(INPUT_POST, "result", FILTER_SANITIZE_STRING); // get the result of playing the game
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL); // get the email address from the user
// get current date
date_default_timezone_set('UTC');
$date = date('Y/m/d H:i:s');
?>

<html>

<head>
    <title>Update Players' Results</title>
    <!-- Author:Zhiping Yu, Student number : 000822513  October 3, 2020
         This file is used to add new player to the players table, update players' wins and losses
        . Plus, find the print the top 10 players' related information based on wins in decending order -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
    <style>
        /* reset properties for play again link */
        a#update {
            text-decoration: underline;
            background-color: ivory;
            width: 140px;
            height: 50px;
            padding: 10px;
            color: blueviolet;
            font-size: 28px;
        }

        /* paragraph for welcome the new player */
        p#greet {
            color: hotpink;
            margin: auto auto;
            padding: 20px;
            width: 500px;
            font-size: 50px;
        }

        /* paragraph for display the wins and losses of the player */
        p.output {
            color: indianred;
            font-size: 40px;
        }

        /* heading for staring show the top 10 players */
        h2 {
            background-color: honeydew;
            color: olivedrab;
        }

        /* output message when email address is invalid */
        p#warning {
            margin: 20px auto;
            width: 500px;
            padding: 20px;
            font-size: 40px;
            color: crimson;
            border: 2px dashed greenyellow;

        }
    </style>
</head>

<body>
    <?php
    if ($email === null || $email === false || $email === "") { // check if the email address exists and  is valid 
        echo "<p id='warning'> Sorry, your email is missing or invalid! please try again!</p><br>";
    } else {
        $command = "SELECT * FROM players WHERE email_address =?";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute([$email]);
        /* check whether or not the email_address has already existed in the table player. 
        if statement can executes and fetchs a record, it means user have played the game and his
        email_address is been recorded into the table*/
        if ($success && $row = $stmt->fetch()) {
            echo "<p id='greet'> Welcome back, Buddy</P>";

        } else {/*If an email does not exist, inserting a new row to the players table,
            but only insert two values for columns email_address and data_last_played. Column wins and
            coloumn losses temporaily only have default values 0*/

            echo "<p id='greet'>Welcome new player!</p>";
            $command = "INSERT INTO players(email_address,date_last_played) VALUES(?,?)";
            $stmt = $dbh->prepare($command);
            $params = [$email, $date];
            $success = $stmt->execute($params);
        }
        /* Obtain the values in column wins and losses based on the result of playing the game. If
            he lost the game, the value in losses column should add 1.Otherwise, the value in the column
            wins should be added 1. The final situation is that variable result is null or false, then
            user should be warned the invalid value or missing value */
        $command = "SELECT wins, losses FROM players WHERE email_address = ?";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute([$email]);
        if ($success && $row = $stmt->fetch()) {

            // check if he won the game of lost the game. When $result = "win", it means he won the game
            if ($result === "win") {
                $row["wins"] += 1; // the value in the column wins should be added 1
                echo "<p class='output'>Your game has been recorded, and you have won $row[wins] and have lost $row[losses] to date.</P>";
                // if $result = "lose", it means he lost the game
            } elseif ($result === "lose") {
                $row["losses"] += 1; // when he lost the game, the value in the column losses should be added 1

                echo "<p class='output'>Your game has been recorded, and you have won $row[wins] and have lost $row[losses]</p>";
                // if $result value is any other values, such as null or false, let user know the possible reason
            } else {
                echo "Sorry, the variable result is invalid or missing.";
            }
        }
        /* update the column wins or column losses values to the table player for the particular player  */
        $command = "UPDATE players SET wins=?, losses=? WHERE email_address = ?";
        $stmt = $dbh->prepare($command);
        $params = [$row["wins"], $row["losses"], $email];
        $success = $stmt->execute($params);
        /* Select top 10 players based on the values in column wins in descending order and print their
           email address, wins, loses and date lastest time*/
        $command = "SELECT * FROM players ORDER BY wins desc  LIMIT 10";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute();
        echo "<h2> Top 10 players results based on the times of wins:</h2>";
        $count = 1;
        if($success){
            while($row = $stmt->fetch()){
                echo "<p>N#:$count, $row[email_address],win:$row[wins],lose:$row[losses],
                 at $row[date_last_played].</p>";
                 ++$count;
            }
        }
    }
    ?>
    <!-- Create a link to go back to the index.php -->
    <a id="update" href="index.php">Play Again</a>
</body>

</html>