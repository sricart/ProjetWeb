<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="http://localhost/code/accueil/nav_etudiant/style.css">
        <title> Candidatures </title>
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

        <?php
                session_start();    
                $Id_Auth = $_SESSION['id'];
                    
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT *
                FROM etudiant 
                JOIN postule 
                ON etudiant.Id_Etudiant = postule.Id_Etudiant
                JOIN offre
                ON postule.Id_Offre = offre.Id_Offre
                JOIN entreprise
                ON offre.Id_Entreprise = entreprise.Id_Entreprise
                WHERE etudiant.Id_Auth = :id
                AND offre.Statut_offre = "ouverte"';
                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Auth, PDO::PARAM_INT);
                $query->execute();
                $etudiant = $query->fetchAll(PDO::FETCH_ASSOC);
                require_once('CRUD_Offre/close.php');
            ?>
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
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($etudiant as $offre){
                        ?>
                            <tr>
                                <td><?= $offre['N_Offre'] ?></td>
                                <td><?= $offre['Statut_offre'] ?></td>
                                <td><?= $offre['N_Entreprise'] ?></td>
                                <td><?= $offre['Duree'] ?></td>
                                <td><?php if($offre['Recommandation'] == 1){
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