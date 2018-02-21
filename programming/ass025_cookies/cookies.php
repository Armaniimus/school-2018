<?php

setcookie("Mycookie", "this is my cookie");

if(isset($_COOKIE["Mycookie"])) {
    echo $_COOKIE["Mycookie"];
}
//
// if(isset($_COOKIE["Mycookie2"])) {
//     echo $_COOKIE["Mycookie2"];
// } else {
//
// }
 ?>
