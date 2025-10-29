<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orphelinat du Château Dimitrescu (Bootstrap)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.0.1/model-viewer.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body class="position-relative">
    
    <nav class="navbar main-navbar navbar-expand-lg sticky-top p-1" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center navbar-gauche" href="#">
                <img src="Capture_d_écran_21-10-2025_165237_www.canva.com-removebg-preview.png" alt="Logo" class="navbar-logo">

                <span class="navbar-title ms-3">Orphelinat</span>
            </a>

            <div class="d-flex navbar-centre-links me-auto ms-5">
                <a href="#link1" class="mystery-box mx-1"><span class="box-text fw-bold">Lien 1</span></a>
                <a href="#link2" class="mystery-box mx-1"><span class="box-text fw-bold">Lien 2</span></a>
                <a href="#link3" class="mystery-box mx-1"><span class="box-text fw-bold">Lien 3</span></a>
            </div>

            <div class="d-flex navbar-right">
                <a href="../inscrit toi/inscrit.php" class="nav-button register-btn btn me-2">Inscris toi</a>
                <a href="../login/login.php" class="nav-button login-btn btn">Login</a>
            </div>
        </div> 
    </nav>

    <div class="bebe_pendu">
        <img src="bebe pendue.png" class="bebe_pendu position-fixed  w-20 h-20 z-5" alt="Bébé pendu">
    </div>

    <img class="Bebe position-fixed" src="freepik__a-childs-broken-porcelain-doll-with-vacant-black-e__26280-removebg-preview.png">
    
    <img src="Fleche-removebg-preview.png" class="fleche-gauche position-fixed" alt="Flèche directionnelle">
    <img src="Fleche-removebg-preview.png" class="fleche-haut position-fixed" alt="Flèche directionnelle">
    <img src="Fleche-removebg-preview.png" class="fleche-droit position-fixed" alt="Flèche directionnelle">
    <img src="Fleche-removebg-preview.png" class="fleche-bas position-fixed" alt="Flèche directionnelle">

    <img class="lady position-fixed z-5" src="DameBlanche.png" alt="dame_blanche">
    
    <div class="text-bulle shadow-lg position-fixed z-5 rounded-5 p-3 ">
        <span class="typewriter-text">
        Au-delà de la rouille et des brumes du Château Dimitrescu, le véritable accueil s'attend pas dans le hall. Il réside dans le silence glacial de ses couloirs. Chut. Vous êtes enfin chez vous.
        </span>
    </div>

    <a href="http://localhost/projet%20orphelina/Page%20Tableaux%20b%c3%a9b%c3%a9/tableaux.html" class="action-text pe-auto position-absolute text-enfant">Enfant pris à charge</a>
    <a href="http://localhost/projet%20orphelina/inscriptionenfants/inscristonenfant.php" class="action-text pe-auto position-absolute text-inscription">Inscrit ton Enfant</a>
    <a href="http://localhost/projet%20orphelina/info%20prof/prof.php" class="action-text pe-auto position-absolute text-prof">Information Prof</a>
    <a href="../restauration/restauration.php" class="action-text pe-auto position-absolute z-5 text-restauration">Restauration</a>

</body>
</html>
