<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Affichage d'une offre</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    </head>
    <body>
        <section class="afficheoffre">
            <?php
                $Id_Offre = $_GET['Id_Offre'];
                
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT `Statut_offre`,`N_Offre`,`Desc_Offre`,
                `Duree`,`Anne2`,`Anne3`,`Anne4`,`Anne5`,`Recommandation`,
                `Remuneration`,`Date_Pub`,`N_Entreprise`,`Note`,`Numero`,
                `N_Rue`,`CodeP`,`CodeP`,`Ville`,`Departement`,`Region`,`Complement`
                FROM offre 
                JOIN entreprise 
                ON offre.Id_Entreprise = entreprise.Id_Entreprise 
                JOIN adresse
                ON adresse.Id_Entreprise = entreprise.Id_Entreprise
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

                echo "<h2>" . "Informations sur l'entreprise :" . "</h2>";
                echo "<p> Nom : " . $offre['N_Entreprise'] . "</p>";
                echo "<p> Note : " . $offre['Note'] . "/5" . "</p>";
                echo "<p> Adresse : " . $offre['Numero'] . " " . $offre['N_Rue'] . " " . $offre['Ville'] . " " . $offre['CodeP'] . "</p>";
            
                require_once('CRUD_Offre/close.php');
            ?>
            <a href="http://localhost/Code/accueil/nav_etudiant/offres_etudiant.php" class="btn_retour">Retour</a>
            <a href="#" class="btn_aff">Ajouter à la liste de souhaits</a>
            <a href="#" class="btn_aff">Postuler</a>
        </section>
        <br>
        <br>
    </body>
</html>