<?php

if (isset($_POST["addproduct"]) && $_POST["addproduct"] === "1") {
    require_once 'pdo_database.php';

    $columnNames = GetCollumnNames("products");
    $columnNames = SelectWithCodeFromArray($columnNames, "02");

    $res = InsertIntoDatabase("products", $columnNames, $_POST);

    if ($res === TRUE) {
        header("Location: ../index.php");
    } else {
        header("Location: ../create_screen.php$res");
    }
}


?>
