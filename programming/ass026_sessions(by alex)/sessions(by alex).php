<?php

// altijd na <!DOCTYPE html> maar voor <html>
session_start();
$_SESSION['views'] = $_SESSION['views'] + 1;
?>
