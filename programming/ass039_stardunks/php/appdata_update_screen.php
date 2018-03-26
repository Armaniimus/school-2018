<?php
require_once 'php/pdo_database.php';
require_once 'php/generate_tables.php';

$where = "WHERE product_id = " . $_GET["id"];
$sql = "SELECT * FROM products $where";

$data = DB_ReadIntoAssoc($sql);


?>
