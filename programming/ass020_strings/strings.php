<?php

    $string = "a bcdefghijklmnopqrstuvwxyz";
    echo substr ($string , 0 ,3) . "<br />";
    // echp substr ( string $string , 0 [, int $length ] )



    echo "<br />";

    $res1 = strstr($string, "klm", true);
    $res2 = strstr($string, "klm", false);
    $res3 = strstr($res1, "klm", false);
    $res4 = strstr($res2, "klm", true);

    echo $res1 . "<br />";
    echo $res2 . "<br />";
    echo $res3 . "<br />";
    echo $res4 . "<br />";


    echo "<br />";




?>
