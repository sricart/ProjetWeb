<?php
    session_start();
    require_once('CRUD_Etudiant/connect.php');
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

    $sql = 'SELECT `Id_Offre`,`N_Offre`,`Statut_Offre`,`N_Entreprise`,`Duree`,`Recommandation`,`Remuneration` FROM offre INNER JOIN entreprise ON offre.ID_Entreprise = offre.ID_Entreprise WHERE `statut_Offre`!="close";';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    require_once('CRUD_Offre/close.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <title> Offres </title>

        <script>
            function afficherInfo() {
                var infos = document.getElementById("infos");
                if (infos.style.display === "none") {
                    infos.style.display = "block";
                } else {
                    infos.style.display = "none";
                }
            }

            function deconnexionConfirm() {
                if (confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
                    window.location.href = "http://localhost/code/index.php";
                    return true;
                } else {
                    return false;
                }
            }
        </script>

    </head>
    
    <body>
        <section class="aff_promo">
        <?php

            $Id_Pilote = $_GET['Id_Pilote'];
                            
            require_once('CRUD_Pilote/connect.php');
            
            $sql = 'SELECT *
            FROM pilote 
            JOIN promotion 
            ON pilote.Id_Pilote = promotion.Id_Pilote 
            WHERE pilote.Id_Pilote = :id';

            $query = $db->prepare($sql);
            $query->bindParam(':id', $Id_Pilote, PDO::PARAM_INT);
            $query->execute();
            $Nom = $query->fetch(PDO::FETCH_ASSOC);

            $sql = 'SELECT *
            FROM pilote 
            JOIN promotion 
            ON pilote.Id_Pilote = promotion.Id_Pilote 
            WHERE pilote.Id_Pilote = :id';

            $query = $db->prepare($sql);
            $query->bindParam(':id', $Id_Pilote, PDO::PARAM_INT);
            $query->execute();
            $pilote = $query->fetchAll(PDO::FETCH_ASSOC);


            echo "<h1>Liste des promotions de " . $Nom['N_Pilote'] . " " . $Nom['P_Pilote'] . " :</h1>";
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
        <br>
        <div id="infos" class="container"  >
        <div class="row">
            <section class="col-12">
                
                <table class="table">
                    <thead>
                        <th>Id Promotion</th>
                        <th>Année et mineure</th>
                        <th>Centre</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($pilote as $pilote){
                        ?>
                            <tr>
                                <td><?= $pilote['Id_Promotion'] ?></td>
                                <td><?= $pilote['Mineur_Annee'] ?></td>
                                <td><?= $pilote['Id_Centre'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            </div>
        </div>
    <a href="http://localhost/Code/accueil/nav_admin/pilotes_admin.php" class="btn_retour">Retour</a>
    </section>
    </body>
</html>