<?php
session_start();
require 'db.php';

if (isset($_POST['envoi'])) {

if (!empty($_POST['Nom'])&& !empty($_POST['mtps'])){
$nom = htmlspecialchars($_POST['Nom']);
$password = sha1($_POST['mtps']);

$verification = $pdo->prepare("SELECT*FROM projet WHERE Nom = ? AND mtps = ?");
$verification->execute(array($nom, $password));

if ($verification->rowCount() > 0){
    $_SESSION['Nom'] = $nom;
    $_SESSION['mtps'] = $password;
    $_SESSION['id'] = $verification->fetch()['id'];

    header('Location = pp.php');
}
else{
    echo 'Votre pseudo est mauvais';
}

}
else{
    echo 'Bug';
}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Château de Dimitrescu - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="login.css"> 

    <link href="https://fonts.googleapis.com/css2?family=Nosifer&display=swap" rel="stylesheet">
</head>
<body class="mt-0 p-0 vh-100 overflow-hidden text-body-tertiary ">

     <h1  class="position-fixed">Login</h1>

    <a href="../page de choix/indexv.php">
     <button class="retour position-absolute ">retour</button>
    </a>
            

    <div class="page-container d-flex flex-column align-items-center justify-content-center vh-100">
    <div class="encadrement position-fixed"></div> 
      <img class="encadrement position-fixed" src="Gemini_Generated_Image_7pkgtx7pkgtx7pkg-removebg-preview.png">
      
        <form action="" method="POST"> 
            <div class="mb-3">
                <label for="Nom" class="login-label position-fixed d-block">Nom d'utilisateur</label>
                <input type="text" class="form-control login-input border border-danger position-fixed" name="Nom" required>
            </div>
                
            <div class="mb-3">
                <label for="password" class="login-label1 position-fixed d-block">Mot de passe</label>
                <input type="password" class="form-control login-input1 border border-danger position-fixed" name="mtps" required>
            </div>
                
            
            <div class="d-grid mt-4">
                <button name="envoi" type="submit" class="p-15 btn btn-danger text-uppercase login-btn border border-danger position-fixed">
                    Connexion
                </button>
            </div>
            
             
        </form>
       
    </div>

</body>
</html>
