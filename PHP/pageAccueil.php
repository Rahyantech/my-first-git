<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" href="../CSS/test.css">    
    <title>Château de Dimitrescu - Accueil<</title>
</head>
<body class='accueil'>
    
    <audio id="myAudio" autoplay loop>
        <source src="../ImageResidentEvil/wind-blowing-sfx-09-423678.mp3" type="audio/mpeg"> 
    </audio>

    <audio id="Rire">
        <source src="../ImageResidentEvil/screaming-woman-in-the-basement.mp3" type="audio/mpeg">
    </audio>

    <div class='d-flex flex-column align-items-center justify-content-end marginTop'>

        <div class='d-flex align-items-end'>
            <h1 class='titreAccueilH1'>Inscrivez vos enfants chez nous</h1>
        </div>
        
        <div >
            <a href="pageIndex.php">
                <img class='boutonEntrer'  src="../ImageResidentEvil/BoutonEntrer.png" alt="">
            </a>
        </div>

        <div>
            <img class='logoAccueil' src="../ImageResidentEvil/logo.png" alt="">
        </div>
    </div>

    <script>
        // Récupération de tous les éléments
        let audRire = document.getElementById("Rire");
        let audAmbiance = document.getElementById("myAudio");
        let videoSnow = document.querySelector(".background-video.opacite");
        let btnEntrer = document.getElementById("enterButton"); 

        // Initialisation de l'Ambiance et des Vidéos (Doit être forcé même si 'autoplay' est présent)
        audAmbiance.play().catch(error => {});
        videoSnow.play().catch(error => {});
        
        // Configuration initiale du volume
        audAmbiance.volume = 0.3;
        audRire.volume = 0.7;

        // Logique au Clic
        btnEntrer.addEventListener('click', function() {
            
            // Jouer le cri
            audRire.currentTime = 0; 
            audRire.play().catch(error => {});
            
            // Démuter l'audio d'ambiance
            if (audAmbiance) {
                if (audAmbiance.muted) {
                    audAmbiance.muted = false;
                }
            }
        });
    </script>
</body>
</html>