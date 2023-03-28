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

    $sql = 'SELECT entreprise.Id_Entreprise, N_Entreprise, Note, Numero, N_Rue, Ville, CodeP, Region
    FROM entreprise 
    JOIN adresse 
    ON entreprise.Id_Entreprise = adresse.Id_Entreprise';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
    {
        // On inclut la connexion à la base
        require_once('CRUD_Offre/connect.php');
        $recherche = $_POST['recherche'];
        // Prépare la requête SQL
        $sql = 'SELECT * 
        FROM `entreprise` 
        INNER JOIN `adresse` 
        ON entreprise.Id_Entreprise = adresse.Id_Entreprise 
        WHERE N_Entreprise 
        LIKE :recherche 
        OR Ville 
        LIKE :recherche 
        OR Region 
        LIKE :recherche 
        OR Departement 
        LIKE :recherche 
        OR Desc_E 
        LIKE :recherche;';
        // On prépare la requête
        $query = $db->prepare($sql);
        // On exécute la requête
        $query->execute(array(':recherche' => '%' . $recherche . '%'));
        // On stocke le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        // Affiche les résultats de la recherche
        $_SESSION['message'] = '<h6>Résultats de la recherche "' . $recherche . '" :</h6>';
        require_once('CRUD_Offre/close.php');
    }
    else 
    {
        // On inclut la connexion à la base
        require_once('CRUD_Offre/connect.php');
        // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
        $sql = 'SELECT * 
        FROM `entreprise` 
        INNER JOIN `adresse`
        ON entreprise.Id_Entreprise = adresse.Id_Entreprise;';
        // On prépare la requête
        $query = $db->prepare($sql);
        // On exécute la requête
        $query->execute();
        // On stocke le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        require_once('CRUD_Offre/close.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page d'affichage des entreprises disponibles pour l'étudiant">
        <meta name="keywords" content="entreprise etudiant">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Entreprises </title>
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
            <h1>Liste des entreprises</h1>
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
                    <input type="text" name="recherche" id="recherche" placeholder=" nom, ville, région, département, secteur">
                    <input type="submit" value="Rechercher">
                </form>
            </section>
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
                                    foreach($result as $entreprise){
                                ?>
                                <tr>
                                    <td><?= $entreprise['N_Entreprise'] ?></td>
                                    <td>
                                        <?php 
                                            if($entreprise['Note'] == 1){
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