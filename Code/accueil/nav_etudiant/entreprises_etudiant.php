<?php
    // On démarre une session
    session_start();
    // On inclut la connexion à la base
    require_once('CRUD_Offre/connect.php');
    // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
    $sql = 'SELECT entreprise.Id_Entreprise, N_Entreprise, Note, Numero, N_Rue, Ville, CodeP, Region
    FROM entreprise 
    JOIN adresse 
    ON entreprise.Id_Entreprise = adresse.Id_Entreprise';
    // On prépare la requête
    $query = $db->prepare($sql);
    // On exécute la requête
    $query->execute();
    // On stocke le résultat dans un tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    require_once('CRUD_Offre/close.php');
    //
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
        <title> Entreprises </title>

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
            <div class="logo"> <img src="http://localhost/code/image/logo.png">
            </div>
            <div class="search-bar">
                <input type="search" class="search" placeholder="rechercher">
            </div>
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

        <h1>Liste des entreprises</h1>
        <?php
        //style="display:none"
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
        <input type="button" onclick="afficherInfo()" value="AFFICHER" class="btn_afficher">
        <br>
        <div id="infos" class="container"  >
        <div class="row">
            <section class="col-12">
                
                <table class="table">
                    <thead>
                        <th>Nom de l'entreprise</th>
                        <th>Note</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Code Postal</th>
                        <th>Region</th>
                        <th>Afficher</th>
                        <th>offre(s)</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $entreprise){
                        ?>
                            <tr>
                                <td><?= $entreprise['N_Entreprise'] ?></td>
                                <td><?php if($entreprise['Note'] == 1){
                                            echo '<i class="fa solid fa-star"></i> ';
                                        }
                                        elseif($entreprise['Note'] == 2){
                                            echo '<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                                        }
                                        elseif($entreprise['Note'] == 3){
                                            echo '<i class="fa solid fa-star"></i> <i class="fa solid fa-star">
                                            </i> <i class="fa solid fa-star"></i>';
                                        }
                                        elseif($entreprise['Note'] == 4){
                                            echo '<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                                            <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i>';
                                        }
                                        elseif($entreprise['Note'] == 5){
                                            echo '<i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                                            <i class="fa solid fa-star"></i> <i class="fa solid fa-star"></i> 
                                            <i class="fa solid fa-star"></i>'; 
                                        }
                                    ?>
                                </td>
                                <td><?= $entreprise['Numero'] . " " . $entreprise['N_Rue'] ?></td>
                                <td><?= $entreprise['Ville'] ?></td>
                                <td><?= $entreprise['CodeP'] ?></td>      
                                <td><?= $entreprise['Region'] ?></td>
                                <td><a href="http://localhost/Code/accueil/nav_etudiant/afficher_entreprises.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa solid fa-eye"></i></a></td>
                                <td><a href="http://localhost/Code/accueil/nav_etudiant/entreprises_offres.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa solid fa-list"></i></a>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            </div>

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