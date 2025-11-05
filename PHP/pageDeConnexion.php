<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=residentEvil", "root", "");

// var_dump($_POST);

if(isset($_POST['envoi'])){
 if(!empty($_POST['nomUtilisateur']) && !empty($_POST['mdpUtilisateur'])){
    $pseudo = htmlspecialchars($_POST['nomUtilisateur']);
    $mdp = sha1($_POST['mdpUtilisateur']);

    $recupUtilisateur = $pdo->prepare('SELECT * FROM utilisateur WHERE nomUtilisateur = ? AND mdpUtilisateur = ? ');
    $recupUtilisateur->execute(array($pseudo, $mdp));

    if($recupUtilisateur->rowCount() > 0){
        $_SESSION['nomUtilisateur'] = $pseudo;
        $_SESSION['mdpUtilisateur'] = $mdp;
        $_SESSION['id'] = $recupUtilisateur->fetch()['id'];

        header('Location: pageIndex.php');

    }else {
        echo"Votre mots de passe ou pseudo est mauvais";
    }

 }else {
    echo "Tes champs ne sont pas complet";
 }

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Château de Dimitrescu - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Nosifier&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/test.css">
</head>

<body class="accueil"> 


    
        <button>
            <a href="pageIndex.php" style='text-decoration:none; color:black;'>
                Retour à l'accueil
            </a>
        </button>
    
    <div class="d-flex flex-column justify-content-end align-items-center marginTop">

        <h1 class="titreAccueilH1 d-flex justify-content-center">Connecte toi </h1>

        <form action="" method='POST'>
            
            <div class='p-2 d-flex justify-content-center'>
                <label for="Nom Utilisateur" class="d-flex align-items-center  pe-5">Nom d'Utilisateur </label>
                <input type="text" name="nomUtilisateur" required>
            </div>

            <div class='p-2 d-flex justify-content-center '>
                <label for="Nom Utilisateur" class="d-flex align-items-center  pe-5">Mots de passe</label>
                <input type="password" name="mdpUtilisateur" required>
            </div>
            
            <div class="mt-3 p-2 d-flex justify-content-center">
                <button class='' type='submit' name="envoi">
                    Connexion
                </button>
            </div>
            
        </form>
    </div>

    
        
</body>
</html>