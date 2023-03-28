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

    $sql2 = 'SELECT `Id_Offre`,`Statut_offre`,`N_Offre`,`Desc_Offre` 
    FROM offre 
    WHERE Recommandation = True 
    AND Statut_offre != "close" 
    ORDER BY Id_Offre 
    DESC LIMIT 5';
    
    $query2 = $connexion->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page d'accueil du pilote">
        <meta name="keywords" content="Accueil pilote">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Accueil</title>
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
            <div class="logo"> <img src="http://localhost/code/image/logo.png"alt="logo"></div>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <nav class="nav-bar">
                <ul>
                    <li>
                        <a href="http://localhost/code/accueil/nav_pilote/accueil_pilote.php">Accueil</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/accueil/nav_pilote/etudiants_pilote.php">Etudiants </a>
                    </li>
                    <li>
                        <a>Entreprises et Offres</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_pilote/entreprises_pilote.php" > Entreprises </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_pilote/offres_pilote.php" > Offres </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Votre compte</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_pilote/compte_pilote.php">Compte</a>
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
            <?php
                $Id_Auth = $_SESSION['id'];                            
                require_once('CRUD_Etudiant/connect.php');          
                $sql = 'SELECT `N_Pilote`, `P_Pilote`
                FROM pilote 
                JOIN authentifiant 
                ON pilote.Id_Auth = authentifiant.Id_Auth
                WHERE authentifiant.Id_Auth = :id';
                                
                $query = $db->prepare($sql);
                $query->bindParam(':id', $Id_Auth, PDO::PARAM_INT);
                $query->execute();
                $pilote = $query->fetch(PDO::FETCH_ASSOC);
                echo "<h2>" . 'Bienvenue ' . $pilote['N_Pilote']  . " " . $pilote['P_Pilote'] . "</h2>";
            ?>
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
                                foreach($result2 as $etudiant2){
                            ?>
                            <tr>
                                <td><?= $etudiant2['Id_Offre'] ?></td>
                                <td><?= $etudiant2['Statut_offre'] ?></td>
                                <td><?= $etudiant2['N_Offre'] ?></td>
                                <td><?= $etudiant['Desc_Offre'] ?></td>
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
                    <a href="http://localhost/code/accueil/nav_pilote/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_pilote/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_pilote/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_pilote/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/code/accueil/nav_pilote/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
        <script src="http://localhost/code/accueil/nav_pilote/app.js"> </script>
    </body>
</html>