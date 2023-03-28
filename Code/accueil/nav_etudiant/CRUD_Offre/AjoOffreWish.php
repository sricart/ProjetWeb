<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postuler</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    session_start();
                        $Id_Auth = $_SESSION['id']; 
                        $Id_Offre = $_GET['Id_Offre'];
                        require_once('connect.php');
                    
                        $sql = 'SELECT Id_Etudiant
                        FROM etudiant 
                        JOIN authentifiant
                        ON etudiant.Id_Auth = authentifiant.Id_Auth
                        WHERE authentifiant.Id_Auth = :id';
                    
                        $query = $db->prepare($sql);
                        $query->bindParam(':id', $Id_Auth, PDO::PARAM_INT);
                        $query->execute();
                        $etudiant = $query->fetch(PDO::FETCH_ASSOC);
                    
                        $sql = 'INSERT INTO `souhaite` (`Id_Offre`,`Id_Etudiant`) VALUES (:Id_Offre, :etudiant);';
                        $query = $db->prepare($sql);
                        $query->bindValue(':Id_Offre', $Id_Offre, PDO::PARAM_STR);
                        $query->bindValue(":etudiant", $etudiant['Id_Etudiant'], PDO::PARAM_STR);
                        $query->execute();
                        $_SESSION['message'] = "Vous avez ajouté l'offre à votre liste de souhaits";
                        require_once('close.php');
                        header("Location: http://localhost/Code/accueil/nav_etudiant/liste_souhaits.php");
                ?>
                <p>Etes-vous sûr de vouloir postuler à l'offre ?</p>
                <a href="http://localhost/Code/accueil/nav_etudiant/offres_etudiant.php" class="btn_retour">Retour</a>
                <form method="post">
                    <button class="btn">Oui</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
