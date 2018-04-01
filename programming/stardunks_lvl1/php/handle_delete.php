<?php

require_once 'pdo_database.php';

DB_Delete("products", $_GET["id"], "product_id");
header("Location: ../index.php");


 ?>
