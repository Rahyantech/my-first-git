<?php
// Connexion a la base avec PDO
$pdo = new PDO("mysql:host=localhost;dbname=orphelina", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
