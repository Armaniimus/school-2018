<?php

if (isset($_GET["alert"])) {
    $message = $_GET["alert"];
    echo "<script type='text/javascript'>alert('$message');</script>";
}
// header("Location: handle_create.php"); /* Redirect browser to this file*/

require_once 'php/pdo_database.php';
require_once 'php/generate_tables.php';

$columnNames = GetCollumnNames("products");

//removes first collumn from array
$columnNames = SelectWithCodeFromArray($columnNames, "02");
// print_r($columnNames);
// $data = DB_GenerateAssoc();;

echo GenerateTable2($columnNames);

?>
