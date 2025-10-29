
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Château de Dimitrescu - Accueil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">    <link rel="stylesheet" href="inscrit.css">

    <link href="https://fonts.googleapis.com/css2?family=Nosifer&display=swap" rel="stylesheet">
</head>
<body class="mt-0 p-0 vh-100 overflow-hidden text-body-tertiary ">

    
    <div class="page-container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="encadrement position-fixed"></div> 
        <img class="encadrement position-fixed" src="Gemini_Generated_Image_7pkgtx7pkgtx7pkg-removebg-preview.png">

        <?php
        session_start();

        if (isset($_SESSION['erreur_inscription'])) {
        echo '<div class="message-erreur-orange alert alert-warning">';
        echo htmlspecialchars($_SESSION['erreur_inscription']);
        echo '</div>';

        unset($_SESSION['erreur_inscription']); 
        }
        ?>
        
        <h1 class="titreHUn mt-5">Inscription</h1>
        
        <form action="insert.php" method="POST"> 
            <div class="mb-3">
                <label for="username" class="login_label position-fixed d-block">Nom</label>
                <input type="text" class="form-control login_input border border-danger position-fixed" name="Nom" required>
            </div>
                
            <div class="mb-3">
                <label for="password" class="login_label1 position-fixed d-block">Mot de passe</label>
                <input type="password" class="form-control login_input1 border border-danger position-fixed" name="mtps" required>
            </div>

            <div class="mb-3">
                <label for="prenom" class="login_label2 position-fixed d-block">prenom</label>
                <input type="text" class="form-control login_input2 border border-danger position-fixed" name="Prenom" required>
            </div>

            <div class="mb-3">
                <label for="age" class="login_label3 position-fixed d-block">age</label>
                <input type="number" class="form-control login_input3 border border-danger position-fixed" name="Age" required>
            </div>


            <div class="mb-3">
                <select class="login_input4 position-absolute"name="Sexe" required>
                    <option value="">Sexe</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>

            <div class="input-group-prepenp">
                <span class="input-group-text login_label6 position-fixed border border-danger">@</span>
            </div>
                <input type="email" class="form-control border border-danger login_input6 position-fixed" placeholder="Email" name="Email" required aria-label="small" aria-describedby="basic-addon1">
            </div>
            <h6 class="position-fixed">Email</h6>

            
            <div class="d-grid mt-4">
                <button id="inscription" type="submit" class="p-15 btn btn-danger text-uppercase login-btn border border-danger position-fixed">
                    valider mon Inscription
                </button>
            </div>
            
        </form>
       
    </div>

</body>
</html>