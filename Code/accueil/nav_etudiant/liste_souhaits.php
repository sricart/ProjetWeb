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

    if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
    {
        // On inclut la connexion à la base
        require_once('CRUD_Offre/connect.php');

        $recherche = $_POST['recherche'];

        // Prépare la requête SQL
        $sql = 'SELECT * FROM `offre` 
        INNER JOIN `entreprise` ON offre.Id_Entreprise = entreprise.Id_Entreprise 
        INNER JOIN `adresse` ON entreprise.Id_entreprise = adresse.Id_Entreprise
        INNER JOIN pilote ON pilote.Id_Pilote = offre.Id_Pilote
        WHERE Statut_Offre LIKE :recherche
        OR Duree LIKE :recherche
        OR N_Entreprise LIKE :recherche
        OR Remuneration LIKE :recherche
        OR Ville LIKE :recherche
        OR Region LIKE :recherche
        OR Departement LIKE :recherche
        OR Desc_Offre Like :recherche
        OR N_Offre Like :recherche;';
        // On prépare la requête
        $query = $db->prepare($sql);
        // On exécute la requête
        $query->execute(array(':recherche' => '%' . $recherche . '%'));
        // On stocke le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        // Affiche les résultats de la recherche
        $_SESSION['message'] = '<h3>Résultats de la recherche "' . $recherche . '" :</h3>';
    }
    else 
    {
        // On inclut la connexion à la base
        require_once('CRUD_Offre/connect.php');
        // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
        $sql = 'SELECT * FROM `offre` 
        INNER JOIN `entreprise` ON offre.Id_Entreprise = entreprise.Id_Entreprise 
        INNER JOIN `adresse` ON entreprise.Id_entreprise = adresse.Id_Entreprise
        INNER JOIN pilote ON pilote.Id_Pilote = offre.Id_Pilote;';
        // On prépare la requête
        $query = $db->prepare($sql);
        // On exécute la requête
        $query->execute();
        // On stocke le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page de la liste de souhait de l'étudiant">
        <meta name="keywords" content="Liste souhait etudiant">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Liste de souhaits </title>
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
            <h1>Liste de souhaits</h1>
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
                <section class="barre">
                    <form method="POST">
                        <label for="recherche">Rechercher :</label>
                        <input type="text" name="recherche" id="recherche" placeholder=" nom, description, ville, région, département, secteur">
                        <input type="submit" value="Rechercher">
                    </form>
                </section>
            <br>
            <?php
                $Id_Auth = $_SESSION['id'];        
                require_once('CRUD_Offre/connect.php');
                $sql = 'SELECT *
                FROM etudiant 
                JOIN souhaite 
                ON etudiant.Id_Etudiant = souhaite.Id_Etudiant
                JOIN offre
                ON souhaite.Id_Offre = offre.Id_Offre
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
                                    foreach($etudiant as $offre){
                                ?>
                                <tr>
                                    <td><?= $offre['N_Offre'] ?></td>
                                    <td><?= $offre['Statut_offre'] ?></td>
                                    <td><?= $offre['N_Entreprise'] ?></td>
                                    <td><?= $offre['Duree'] ?></td>
                                    <td><?php 
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