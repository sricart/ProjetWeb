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

try{
    $user='root';
    $pass='';
    $bd='projet';
    $serveur='localhost';
    $connexion = new PDO("mysql:host=$serveur;dbname=$bd", $user, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

    $sql = 'SELECT `Id_Offre`,`Statut_offre`,`N_Offre`,`Desc_Offre` FROM offre ORDER BY Id_Offre DESC LIMIT 5';
    $query = $connexion->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);


    $sql2 = 'SELECT `N_Etudiant`,`P_Etudiant`,COUNT(postule.Id_Etudiant) 
    FROM etudiant 
    INNER JOIN postule ON etudiant.Id_Etudiant = postule.Id_Etudiant 
    GROUP BY etudiant.Id_etudiant 
    ORDER BY COUNT(postule.Id_Etudiant) DESC LIMIT 5';

    $query2 = $connexion->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    $sql3 = 'SELECT `N_Entreprise`,COUNT(offre.Id_Entreprise) 
    FROM entreprise 
    INNER JOIN offre ON entreprise.Id_Entreprise = offre.Id_Entreprise 
    GROUP BY offre.Id_Entreprise 
    ORDER BY COUNT(offre.Id_Entreprise) DESC LIMIT 5';

    $query3 = $connexion->prepare($sql3);
    $query3->execute();
    $result3 = $query3->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page d'accueil pour l'admin">
        <meta name="keywords" content="accueil admin">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <title> Accueil </title>
        <script>
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
        <header>
            <div class="logo"> <img src="http://localhost/code/image/logo.png" alt="logo"></div>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <nav class="nav-bar">
                <ul>
                    <li>
                        <a href="http://localhost/code/accueil/nav_admin/accueil_admin.php">Accueil</a> 
                    </li>
                    <li>
                        <a>Utilisateurs</a> 
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_admin/etudiants_admin.php">Etudiants </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_admin/pilotes_admin.php">Pilotes </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Entreprises et Offres</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_admin/entreprises_admin.php" > Entreprises </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_admin/offres_admin.php" > Offres </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Votre compte</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_admin/compte_admin.php">Compte</a>
                                </li>
                                <li>
                                    <a onclick="return deconnexionConfirm();" href="http://localhost/code/index.php">Déconnexion </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <br>
        <main>
            <section class="stat">
                <div class="container">
                    <table class="table_accueil">
                        <thead>
                            <th>ID</th>
                            <th>Statut</th>
                            <th>Offre</th>
                            <th>Description</th>
                        </thead>
                        <tbody>
                            <?php
                            // On boucle sur la variable result
                            foreach($result as $etudiant){
                            ?>
                                <tr>
                                    <td><?= $etudiant['Id_Offre'] ?></td>
                                    <td><?= $etudiant['Statut_offre'] ?></td>
                                    <td><?= $etudiant['N_Offre'] ?></td>
                                    <td><?= $etudiant['Desc_Offre'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table_accueil">
                        <thead>
                            <th>Nom</th>
                            <th>ID</th>
                            <th>Nb postule</th>
                        </thead>
                        <tbody>
                            <?php
                                foreach($result2 as $etudiant2){
                            ?>
                                <tr>
                                    <td><?= $etudiant2['N_Etudiant'] ?></td>
                                    <td><?= $etudiant2['P_Etudiant'] ?></td>
                                    <td><?= $etudiant2['COUNT(postule.Id_Etudiant)'] ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <table class="table_accueil">
                        <thead>
                            <th>Nom entreprise</th>
                            <th>nb offres proposées</th>
                        </thead>
                        <tbody>
                            <?php
                                foreach($result3 as $etudiant3){
                            ?>
                                <tr>
                                    <td><?= $etudiant3['N_Entreprise'] ?></td>
                                    <td><?= $etudiant3['COUNT(offre.Id_Entreprise)'] ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        <br>
        <footer>
            <ul>
                <li>
                    <a href="http://localhost/code/accueil/nav_admin/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_admin/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_admin/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_admin/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_admin/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
        <script src="http://localhost/code/accueil/nav_admin/app.js"> </script>
    </body>
</html>
