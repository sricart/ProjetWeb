<?php
    // On démarre une session
    session_start();
    // On inclut la connexion à la base
    require_once('CRUD_Offre/connect.php');
    // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
    $sql = 'SELECT `Id_Offre`,`N_Offre`,`Statut_Offre`,`N_Entreprise`,`Duree`,`Anne2`,`Anne3`,`Anne4`,`Anne5`,`Recommandation`,`Remuneration` FROM offre INNER JOIN entreprise ON offre.ID_Entreprise = offre.ID_Entreprise WHERE `statut_Offre`!="close";';
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

            function popup() {
                var leftPosition, topPosition;
                var width = 1000;
                var height = 800;
                // Calculer la position X pour centrer la fenêtre modale.
                leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
                // Calculer la position Y pour centrer la fenêtre modale.
                topPosition = (window.screen.height / 2) - ((height / 2) + 50);
                // Ouvrir la fenêtre modale centrée.
                //window.open("http://localhost/test/CRUD_Offre/nav_etudiant/afficher_offres.php", "popup", "width="+width+",height="+height+",left="+leftPosition+",top="+topPosition);
                //onclick="popup()"
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
                                    <a href="http://localhost/code/index.php">Déconnexion </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <br>

        <h1>Liste des offres</h1>
        <?php
        //onclick="return deconnexionConfirm();
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
                        <th>ID</th>
                        <th>Nom de l'offre</th>
                        <th>Statut</th>
                        <th>Nom de l'entreprise</th>
                        <th>Durée</th>
                        <th>Recommandé</th>
                        <th>Rémunération</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $offre){
                        ?>
                            <tr>
                                <td><?= $offre['Id_Offre'] ?></td>
                                <td><?= $offre['N_Offre'] ?></td>
                                <td><?= $offre['Statut_Offre'] ?></td>
                                <td><?= $offre['N_Entreprise'] ?></td>
                                <td><?= $offre['Duree'] ?></td>
                                <td><?= $offre['Recommandation'] ?></td>
                                <td><?= $offre['Remuneration'] ?></td>
                                <td><a href="http://localhost/test/CRUD_Offre/nav_etudiant/afficher_offres.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa solid fa-eye"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            </div>
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