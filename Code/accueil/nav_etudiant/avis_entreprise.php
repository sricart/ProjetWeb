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
                $Id_Entreprise = $_GET['Id_Entreprise'];
                
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT *
                FROM evaluation 
                WHERE evaluation.Id_Entreprise = :id';
                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Entreprise, PDO::PARAM_INT);
                $query->execute();
                $entreprise = $query->fetchAll(PDO::FETCH_ASSOC);
            
                require_once('CRUD_Offre/close.php');
            ?>

            <div id="infos" class="container"  >
                <div class="row">
                    <section class="col-12"> 
                            <table class="table">
                                <thead>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                </thead>
                                <tbody>
                                    <?php
                                    // On boucle sur la variable result
                                    foreach($entreprise as $avis){
                                    ?>
                                        <tr>
                                            <td><?= $avis['Note'] ?></td>
                                            <td><?= $avis['Commentaire'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </section>
                </div>
            </div>

            <a href="http://localhost/Code/accueil/nav_etudiant/afficher_entreprises.php?Id_Entreprise=<?= $avis['Id_Entreprise'] ?>" class="btn_retour"> Retour</a>
        </section>
        <br>
        <br>
    </body>
</html>