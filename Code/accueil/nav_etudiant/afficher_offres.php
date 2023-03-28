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
        <meta name="description" content="Page d'affichage d'une offre disponible pour l'étudiant">
        <meta name="keywords" content="offre etudiant">
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
                $Id_Offre = $_GET['Id_Offre'];
                
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT *
                FROM offre 
                JOIN entreprise 
                ON offre.Id_Entreprise = entreprise.Id_Entreprise 
                JOIN adresse
                ON adresse.Id_Entreprise = entreprise.Id_Entreprise
                JOIN pilote
                ON pilote.Id_Pilote = offre.Id_Pilote
                WHERE Id_Offre = :id';
                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Offre, PDO::PARAM_INT);
                $query->execute();
                $offre = $query->fetch(PDO::FETCH_ASSOC);

                echo "<h1>" . $offre['N_Offre'] . ' - Pour l\'entreprise : ' . $offre['N_Entreprise']  .  "</h1>";
                echo "<h2>" . "Description de l'offre :" . "</h2>";
                echo $offre['Desc_Offre'];
                echo "<h2>" . "Informations supplémentaires sur l'offre :" . "</h2>";
                echo "<p>Durée(s) : " . $offre['Duree'] . "</p>";
                echo "<p>Année(s) concernée(s) : </p>";
                if ($offre['Anne2'] == 1) {
                    echo "<p>Années 2 </p>";
                }
                if ($offre['Anne3'] == 1) {
                    echo "<p>Années 3 </p>";
                }
                if ($offre['Anne4'] == 1) {
                    echo "<p>Années 4 </p>";
                }
                if ($offre['Anne5'] == 1) {
                    echo "<p>Années 5 </p>";
                }
                if($offre['Recommandation'] == 1){
                    $reco = '<i class="fa solid fa-thumbs-up"></i>';
                }
                else{
                    $reco = '<i class="fa solid fa-thumbs-down"></i>';
                }
                
                echo "<p>Recommandation : " . $reco . "</p>";
                echo "<p>Rémunération : " . $offre['Remuneration'] . "</p>";
                echo "<p>Pour plus d'information, joindre : " . $offre['N_Pilote'] . " " . $offre['P_Pilote'] . "</p>";

                echo "<h2>" . "Informations sur l'entreprise :" . "</h2>";
                echo "<p> Nom : " . $offre['N_Entreprise'] . "</p>";
                if($offre['Note'] == 1){
                    $star ='<i class="fa solid fa-star"></i> ';
                }
                elseif($offre['Note'] == 2){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                }
                elseif($offre['Note'] == 3){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star">
                    </i> <i class="fa solid fa-star"></i>';
                }
                elseif($offre['Note'] == 4){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                }
                elseif($offre['Note'] == 5){
                    $star ='<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                    <i class="fa solid fa-star"></i>';
                }
                echo "<p> Note : " . $star . "</p>";
                echo "<p> Adresse : " . $offre['Numero'] . " " . $offre['N_Rue'] . " " . $offre['Ville'] . " " . $offre['CodeP'] . "</p>";
            
                require_once('CRUD_Offre/close.php');
            ?>
            <a href="http://localhost/Code/accueil/nav_etudiant/offres_etudiant.php" class="btn_retour">Retour</a>
            <a href="http://localhost/Code/accueil/nav_etudiant/CRUD_Offre/AjoOffre.php?Id_Offre=<?= $offre['Id_Offre'] ?>" class="btn_aff">Postuler</a>
            <a href="http://localhost/Code/accueil/nav_etudiant/CRUD_Offre/AjoOffreWish.php?Id_Offre=<?= $offre['Id_Offre'] ?>" class="btn_aff">Ajouter à la liste de souhaits</a>
        </section>
        <br>
        <br>
    </body>
</html>