<?php
    session_start();
    require_once('CRUD_Offre/connect.php');
        
    $authenticated = false;
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql = 'SELECT Id_Auth 
        FROM authentifiant 
        WHERE Id_Auth = :id';
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

    $Id_Entreprise = $_GET['Id_Entreprise'];
    $sql = "SELECT *
    FROM offre 
    INNER JOIN entreprise 
    ON offre.Id_Entreprise = entreprise.ID_Entreprise 
    WHERE `statut_Offre`!='close'
    AND entreprise.Id_Entreprise = :id;";

    $query = $db->prepare($sql);
    $query->bindParam(':id', $Id_Entreprise, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page d'affichage des offres d'une entreprise disponibles pour l'étudiant">
        <meta name="keywords" content="entreprise offre etudiant">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <a href="http://localhost/code/accueil/nav_etudiant/accueil_etudiant.php">Accueil</a> 
                    </li>
                    <li>
                        <a>Pistes</a> 
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_etudiant/candidatures.php" >Candidatures </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_etudiant/liste_souhaits.php" >Liste de souhaits </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Entreprises et Offres</a> 
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_etudiant/entreprises_etudiant.php" > Entreprises </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_etudiant/offres_etudiant.php" > Offres </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Votre compte</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_etudiant/compte_etudiant.php">Compte</a>
                                </li>
                                <li>
                                    <a onclick="return deconnexionConfirm()" href="http://localhost/code/index.php">Déconnexion </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <br>
        
        <main>
            <h1> Offre(s) de l'entreprise </h1>
            <br>
            <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                    $_SESSION['erreur'] = "";
                }
            ?>
            <?php
                if(!empty($_SESSION['message'])){
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                    $_SESSION['message'] = "";
                }
            ?>
            <a href="http://localhost/Code/accueil/nav_etudiant/entreprises_etudiant.php" class="btn_retour">Retour</a>
            <br>
            <div id="infos" class="container"  >
                <div class="row">
                    <section class="col-12">
                        <table class="table">
                            <thead>
                                <th>Nom de l'offre</th>
                                <th>Statut</th>
                                <th>Nom de l'entreprise</th>
                                <th>Durée</th>
                                <th>Recommandé</th>
                                <th>Rémunération</th>
                                <th>Voir</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($result as $offre){
                                ?>
                                <tr>
                                    <td><?= $offre['N_Offre'] ?></td>
                                    <td><?= $offre['Statut_offre'] ?></td>
                                    <td><?= $offre['N_Entreprise'] ?></td>
                                    <td><?= $offre['Duree'] ?></td>
                                    <td>
                                        <?php 
                                            if($offre['Recommandation'] == 1){
                                                echo '<i class="fa solid fa-thumbs-up"></i>';
                                            }
                                            else{
                                                echo '<i class="fa solid fa-thumbs-down"></i>';
                                            } 
                                        ?>       
                                    </td>
                                    <td><?= $offre['Remuneration'] ?></td>
                                    <td><a href="http://localhost/Code/accueil/nav_etudiant/afficher_offres.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa solid fa-eye"></i></a></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </main>
        <br>

        <footer>
            <ul>
                <li>
                    <a href="http://localhost/code/accueil/nav_etudiant/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_etudiant/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_etudiant/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_etudiant/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_etudiant/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
        <script src="http://localhost/code/accueil/nav_etudiant/app.js"> </script>
    </body>
</html>