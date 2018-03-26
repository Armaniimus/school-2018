<?php

require_once 'php/pdo_database.php';
require_once 'php/generate_tables.php';

$sql = "SELECT * FROM products";
$data = DB_ReadIntoAssoc($sql);
echo GenerateTableWithButtons($data);
// echo DB_getResultCount("products");

?>
