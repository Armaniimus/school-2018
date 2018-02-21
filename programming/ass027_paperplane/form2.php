<!DOCTYPE html>
<?php
    session_start();
    $_SESSION = $_POST;
 ?>
<html>
    <head>
        <meta charset="utf-8">
        <title>form2</title>
    </head>
    <body>
        <form action="showforms.php" method="post">
            Color:<input type="color" name="color"><br />
            Omschrijving:<input type="text" name="omschrijving"><br />
            <input type="submit" name="" value="Submit">
        </form>
    </body>
</html>
