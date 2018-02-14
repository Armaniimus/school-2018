<?php
function myAwsomeness($name) {
    return $name;
}

echo $name = myAwsomeness("peter") . "<br>";

function table($nr, $times) {
    $result = "";
    for ($i=1; $i <=$times; $i++) {
        $result .= "$i x $nr = " . $nr*$i . "<br>";
    }
    return $result;
}

function tables($amountOfTables, $amountOfSums) {
    $result = "";
    for ($i=1; $i <=$amountOfTables ; $i++) {
        $result .= table($i, $amountOfSums) . "<br>";
    }

    return $result;
}

echo tables(200, 10)
?>
