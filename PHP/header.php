<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orphelinat du Château Dimitrescu (Bootstrap)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Eater&display=swap" rel="stylesheet">
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.0.1/model-viewer.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../CSS/test.css">
</head>

<body>
    
    <header class="d-flex flex-column">
        
        <nav class="navbar main-navbar navbar-expand-lg sticky-top p-1" data-bs-theme="dark">
            <div class="container-fluid navbarMargeLogo">
                <a class="navbar-brand d-flex align-items-center navbar-gauche" href="pageAccueil.php">
                    <img src="../ImageResidentEvil/logo.png" alt="Logo" class="navbar-logo">
                    <span class="navbar-title d-flex ms-3">Orphelinat</span>
                </a>
                
                <div class="bar_Nav d-flex justify-content-center me-4">
                </div>
                
                    
                    <!-- Juste oublier le session_start(); mais fier de ça solo -->
                    
                <div class="d-flex navbar-right">

                        <?php 
                        if (!isset($_SESSION['id'])) {
                            echo '<a href="pageInscription2.php" class="nav-button register-btn btn me-2">Inscris toi</a>';
                        } else {
                            echo '';
                        }   
                        ?>

                        
                    <?php  
                    if (!isset($_SESSION['id'])) {
                        echo  '<a href="pageDeConnexion.php" class="nav-button login-btn btn" name="connexion">Login</a>'; 
                    } else {
                        echo  '<a href="deconnexion.php" class="nav-button login-btn btn" name="deconnexion">Logout</a>'; 
                    }
                    ?>     
                </div>
            </div> 
        </nav>
        
        
    </header>


