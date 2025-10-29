<?php 
session_start();
require 'db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Age']) && !empty($_POST['Email']) && !empty($_POST['Sexe']) && !empty($_POST['mtps']) ) {
        
        $nom = trim($_POST['Nom']);
        $prenom = trim($_POST['Prenom']);
        $age = (int)$_POST['Age'];
        $email = trim($_POST['Email']);
        $sexe = $_POST['Sexe'];
        $password = $_POST['mtps']; 
           
        try{
            //verifier si le nom de lutilisateur ou leamil exist deja dans la table
            $verification_sql = "SELECT COUNT(*) FROM projet WHERE Nom = :nom OR Email = :email";
            //SELECT COUNT sert à compter toutes les lignes qui correspondent au critere specifier
            //:email = requete preparer pour bonne securiter(marqueur de parametre)
            
            $verification_stmt = $pdo->prepare($verification_sql);
            
            $verification_stmt->execute([
                ':nom' => $nom, 
                ':email' => $email
            ]);
            
            $count = $verification_stmt->fetchColumn(); 
        
            if ($count > 0) {
                $_SESSION['erreur_inscription'] = "Ce nom d'utilisateur ou cet email est déjà utilisé(e).";
                header('Location: inscrit.php'); 
                exit();
                
            } else {
                
                $password_hache = password_hash($password, PASSWORD_DEFAULT );
        
                $sql = "INSERT INTO projet (Nom, Prenom, Age, Email, Sexe, mtps) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$nom, $prenom, $age, $email, $sexe, $password_hache]);
                   
                header('Location: login.php'); 
                exit;
            }
            
        } catch (PDOException $e){
              echo "<p style='color:red;'>Erreur lors de l'ajout dans la base de données.</p>";
              echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    
    } else {
        echo "<p style='color:red;'>Tous les champs sont obligatoires.</p>";
        echo "<p><a href='inscrit.php'>Retour au formulaire</a></p>";
    }
} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}

?>