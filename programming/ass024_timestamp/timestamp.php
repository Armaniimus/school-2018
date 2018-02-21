<?php

    $timeStamp = mktime(02, 02, 00, date("d"), date("m"), date("Y")-20);

    $date = date("d-M-Y", $timeStamp);


    echo $timeStamp . "<br />";;
    echo $date . "<br />";

    echo "CurrentTime in 12 Hour format:" . date("h:i:s A"). "<br />";
    echo "CurrentTime in 24 Hour format:" . date("G:i:s A"). "<br />";

    echo "Date and time (12 hour format):" . date()
    // echo "Date and time (24 hour format): " . date("m/d/")


 ?>
