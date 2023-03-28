<?php
    session_start();
    require_once('CRUD_Offre/connect.php');
    $authenticated = false;
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql = 'SELECT Id_Auth FROM authentifiant WHERE Id_Auth = :id';
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ($row['Id_Auth'] == $id) {
                $authenticated = true;
                break;
            }
        }
    }
    if (!$authenticated) {
        header("Location: http://localhost/Code/index.php");
       exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page d'affichage d'une entreprise disponible pour l'étudiant">
        <meta name="keywords" content="entreprise etudiant">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Affichage d'une offre</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <section class="afficheoffre">
            <?php
                $Id_Entreprise = $_GET['Id_Entreprise'];
                
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT *
                FROM entreprise 
                JOIN adresse 
                ON entreprise.Id_Entreprise = adresse.Id_Entreprise 
                WHERE entreprise.Id_Entreprise = :id';
                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Entreprise, PDO::PARAM_INT);
                $query->execute();
                $entreprise = $query->fetch(PDO::FETCH_ASSOC);

                echo "<h2>" . 'Entreprise : ' . $entreprise['N_Entreprise']  .  "</h2>";
                echo "<p>" . "Description de l'entreprise : ";
                echo $entreprise['Desc_E'] . "</p>" ;
                if($entreprise['Note'] == 1){
                    $star ='<i class="fa solid fa-star"></i> ';
                }
                elseif($entreprise['Note'] == 2){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                }
                elseif($entreprise['Note'] == 3){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star">
                    </i> <i class="fa solid fa-star"></i>';
                }
                elseif($entreprise['Note'] == 4){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                }
                elseif($entreprise['Note'] == 5){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i>';
                }
                echo "<p> Note : " . $star . "</p>";
                echo "<h2>" . "Adresse :" . "</h2>";
                echo "<p> Adresse : " . $entreprise['Numero'] . " " . $entreprise['N_Rue'] . " " . $entreprise['Ville'] . " " . $entreprise['CodeP'] . "</p>";
            
                require_once('CRUD_Offre/close.php');
            ?>
            <a href="http://localhost/Code/accueil/nav_etudiant/offres_etudiant.php" class="btn_retour">Retour</a>
            <a href="http://localhost/Code/accueil/nav_etudiant/entreprises_offres.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>" class="btn_aff">offres de l'entreprise</a>
            <a href="http://localhost/Code/accueil/nav_etudiant/avis_entreprise.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>" class="btn_aff">Avis</a>
        </section>
        <br>
        <br>
    </body>
</html>