<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <title> Compte </title>
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

        <section class="affInfo">
            <?php
                session_start();    
                $Id_Auth = $_SESSION['id'];
                    
                require_once('CRUD_Offre/connect.php');
                
                $sql = 'SELECT *
                FROM authentifiant 
                JOIN etudiant 
                ON authentifiant.Id_Auth = etudiant.Id_Auth
                JOIN promotion
                ON etudiant.Id_Promotion = promotion.Id_Promotion
                JOIN pilote
                ON promotion.Id_Pilote = pilote.Id_Pilote 
                WHERE authentifiant.Id_Auth = :id';
                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Auth, PDO::PARAM_INT);
                $query->execute();
                $etudiant = $query->fetch(PDO::FETCH_ASSOC);

                echo "<h2> Informations personnelles : </h2>";
                echo "<p> Nom : " . $etudiant['N_Etudiant'] . "</p>"; 
                echo "<p> Prénom : " . $etudiant['P_Etudiant'] . "</p>";
                echo "<p> Statut du stage : " . $etudiant['Statut_Stage'] . "</p>";
                echo "<p> Promotion : " . $etudiant['Id_Promotion'] . "</p>";
                echo "<p> Centre : " . $etudiant['Id_Centre'] . "</p>";
                echo "<p> Pilote : " . $etudiant['N_Pilote'] . " " . $etudiant['P_Pilote'] . "</p>";

            ?>
        </section>

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