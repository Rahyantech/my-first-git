<?php   


//en cas d'échec ou de table vide
$poids_moyen = 0.0;
$taille_moyenne = 0.0;
$age_moyen = 0.0;


require 'dbResidentEvil.php'; 

try {

    $stmt = $pdo->query("
        SELECT 
            AVG(poids) AS moyenne_poids, 
            AVG(taille) AS moyenne_taille,
            AVG(TIMESTAMPDIFF(YEAR, dateDeNaissance, CURDATE())) AS moyenne_age
        FROM 
            enfant
    ");
    
    //$moyennes 'false' si table vide.
    $moyennes = $stmt->fetch(PDO::FETCH_ASSOC);

    // si echoue
    if ($moyennes === false || $moyennes['moyenne_poids'] === null) {
        // les variable reste a 0
    } else {
        // moyenne avec float pour nombre decimaux
        $poids_moyen = (float)$moyennes['moyenne_poids'];
        $taille_moyenne = (float)$moyennes['moyenne_taille'];
        $age_moyen = (float)$moyennes['moyenne_age'];
    }

} catch (PDOException $e) {
    // En cas d'erreur on affiche un message.
    error_log("Erreur: " . $e->getMessage());
}

// tableaux ---
$donnees_graphique = array();


// titre colonne
$donnees_graphique[] = array('Métrique', 'Moyenne');

// les categorie son calculer par rapport a laxe x(ordre,category) et laxe y est est determiner par la valeur numerique(hauteur)
$donnees_graphique[] = array('Poids Moyen (kg)', $poids_moyen);
$donnees_graphique[] = array('Taille Moyenne (cm)', $taille_moyenne);
$donnees_graphique[] = array('Âge Moyen (ans)', $age_moyen); 

$donnees_json = json_encode($donnees_graphique); //lier php au js 



include 'header.php';

   if(!isset($_SESSION['id'])) {
    header('location: pageInscription2.php');
    exit;

    
}
?>

<main class="bodyTableaux min-vh-100 ">

    
<div class="titre text-body-secondary d-flex justify-content-center align-items-center m-4">
    <h1 class="titre">Tableaux de stockage des enfants</h1>
</div>


<table class="d-flex justify-content-center align-items-center fs-5 m-5 ">
    <tr class="titreHeader ">
        <th class="border-end border-black px-3 pt-1 pb-1 borderID">ID</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Nom de Famille</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Prénom</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Date de naissance</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Taille en cm</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Poids en KG</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Sexe Biologique</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Date d'arriver à l'orphelinat</th>
        <th class="border-end border-black px-3 pt-1 pb-1">Souvenirs</th>
        <th class="px-3 pt-1 pb-1 borderEcole">Ecole</th>
    </tr>

    <tr class="opacity-50 fw-bolder">
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">1</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black ">Tete de neux</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">Tete d'oeuf</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">17/08/6699</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">185cm</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">50kg</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">Garçon</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">23/08/2000 20h36</td>
        <td class="px-3 pt-1 pb-1 bg-white border-end border-black">Souvenirs</td>
        <td class="px-3 pt-1 pb-1 bg-white">Serpentar</td>
    </tr>

    <tr class="opacity-50 fw-bolder">
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">10</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">Tete a poids </td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">Tete de glands</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">17/08/6698</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">180cm</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">300kg</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">Fille</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">23/08/2000 20h36</td>
        <td class="px-3 pt-1 pb-1 bg-secondary border-end border-black">Souvenirs</td>
        <td class="px-3 pt-1 pb-1 bg-secondary">Serpentar</td>
    </tr>


</table>

<script type="text/javascript">
      
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(dessinerHistogramme); 

      function dessinerHistogramme() {
        
        
        var donnéesMoyennes = google.visualization.arrayToDataTable(<?php echo $donnees_json; ?>);

       
        var options = {
         vAxis: { 
         title: "Valeur Moyenne",
         titleTextStyle: { color: '#8B0000' },
         textStyle: { color: '#8B0000' }
        },
        hAxis: { 
         title: "Métrique",
         titleTextStyle: { color: '#8B0000' },
         textStyle: { color: '#8B0000' }
        },
          colors: ['#8B0000'],
          chartArea:{ backgroundColor: 'transparent'}
          
        };

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(donnéesMoyennes, options); 
      }
    </script>
</head>

<body>

  <div class="container" style="margin-top: 20rem;">

    <div class="d-flex justify-content-center">

        <div class="border bg-dark rounded-3 shadow-lg p-3">       
        <h2 class="text-center mb-2">
            <span class="couleur_rouge_dark">Le</span>
            <span class="couleur_gris_clair">graphique</span>
            <span class="couleur_rouge_dark">de</span>
            <span class="couleur_gris_clair">Andrei</span>
            <span class="couleur_rouge_dark">Chikatilo</span>
        </h2>

          <hr class="border-secondary mt-0 mb-3"> 
        
        <div id="chart_div" style="width: 500px; height: 300px;"></div>
                
        </div>
     </div>
 
   </div>
</body>

<audio id="myCrie" src="/Projet/Audio/MontageAudio/ResidentEvilCrieBebe.mp4" autoplay loop ></audio>
<script src="/Projet/Audio/ParametreAudio/parametreAudioTableauxEnfant.js"></script>

</main>


</html>