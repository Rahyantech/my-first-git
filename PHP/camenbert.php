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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Histogramme Dynamique - Orphelinat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><!--lien librairie google charts-->
    <script type="text/javascript">
      
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(dessinerHistogramme); 

      function dessinerHistogramme() {
        
        
        var donnéesMoyennes = google.visualization.arrayToDataTable(<?php echo $donnees_json; ?>);

       
        var options = {
          title: "💀 Rapport d'Opérations #J-365: L'Orphelinat ou L'infanticide",
          legend: { position: 'none' }, // Masque legende
          vAxis: { title: "Valeur Moyenne" },
          hAxis: { title: "Métrique" },
          colors: ['#8B0000'] 
        };

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(donnéesMoyennes, options); 
      }
    </script>
</head>

<body>
    
    <div class="container mt-5">
        
        <h1 class="text-center text-danger mb-4">Le graphique de Andrei Chikatilo</h1>
        
        <div class="d-flex justify-content-center">
            <div id="chart_div" style="width: 700px; height: 400px;"></div>
        </div>
        
    </div>
</body>
</html>