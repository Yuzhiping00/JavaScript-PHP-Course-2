<!DOCTYPE html>
<?php
include "connect.php";
$r = filter_input(INPUT_GET,"row",FILTER_VALIDATE_INT);// get row 
$c = filter_input(INPUT_GET,"col",FILTER_VALIDATE_INT); // get column
/* prepare and execute the table wumpuses */
$command =  "SELECT * FROM wumpuses WHERE wumpuse_row=? AND wumpuse_column = ?";
$stmt = $dbh->prepare($command);
$params = [$r,$c];
$success = $stmt->execute($params);
?>
<html>

<head>
    <title>Find the Wumpuse</title>
    <!-- Author:Zhiping Yu, Student number : 000822513  October 3, 2020
         This file is used to decide if user found the wumpses or not, 
         connect to and send parameters to the next page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
    <style>
        p#win{
            color: green;
            font-size: 45px;
        }
        p#lose{
            color:red;
            font-size: 45px;
        }

    </style>
</head>

<body>
    <?php
    /*check if a record exists and statement executes successfully. If so, it means we found the wumpuse
    , and we use a new varibale result , assignment string value "win" to record this outcome. Otherwise,
    we assign "lose" to the variable result, which means we did not find the wumpse */
    if($success && $row=$stmt->fetch()){
        $result = "win";// means we found the wumpuse
        echo "<p id = 'win'>YOU HAVE FOUND THE WUMPUSE!
        <img src='img_win.png' alt='Win sign' width = '150' height = '150'></P>";
    }else{
        $result = "lose";// means we did not find the wumpse
        echo "<p id='lose'>SORRY,YOU LOST THE GAME, PLEASE TRY AGAIN!
        <img src='img_lost.png' alt='lost sign'
        width = '100' height = '100'></P>";
    }
    ?>
    <!-- use post method to pass value to the save.php in order to improve the security-->
    <form action = "save.php" method="post">

       Email: <input type="email" name = "email" required><br><br>
              <input type="hidden" name="result" value="<?=$result?>">
              <input type ="submit" value="Submit It!">
    </form>
    
</body>
</html>