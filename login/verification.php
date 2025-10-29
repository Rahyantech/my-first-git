<?php

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!empty($_POST['Nom'])&&!empty($_POST['mtps']) ) {
$nom = htmlspecialchars($_POST['Nom']);
$password = sha1($_POST['mtps']);

$verification_sql = "SELECT*FROM projet WHERE Nom = ? AND mtps = ?";
$verification_stmt = $pdo->prepare($verification_sql);
$verification_stmt = execute(array($nom, $password));

if ($verification_stmt->rowCount() > 0){
    $_SESSION['Nom'] = $nom;
    $_SESSION['mtps'] = $password;
    $_SESSION['id'] = $verification_stmt->fetch()['id'];

    header('Location = pp.php');
    exit;
}

}}