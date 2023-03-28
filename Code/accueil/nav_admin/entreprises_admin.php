<?php
    session_start();
    require_once('CRUD_Entreprise/connect.php');
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
        require_once('CRUD_Entreprise/connect.php');
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
        require_once('CRUD_Entreprise/close.php');
    }
    else 
    {
        // On inclut la connexion à la base
        require_once('CRUD_Entreprise/connect.php');
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
    }
    require_once('CRUD_Entreprise/close.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Entreprises & Offres </title>
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
        <h1>Liste des entreprises</h1>

        <?php
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


        <section class="barre">
        <input type="button" onclick="afficherInfo()" value="AFFICHER" class="btn_afficher">
        <form id="infos" method="POST" style="display:none">
                    <label for="recherche">Rechercher :</label>
                    <input type="text" name="recherche" id="recherche" placeholder=" nom, ville, région, département, secteur">
                    <input type="submit" value="Rechercher">
                </form>
        </section>
       
        <br>
        <main class="container">
        <div class="row">
            <section class="col-12">


                <!-- Affichage des résultats -->
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Siret</th>
                        <th>Nombre d'étudiant</th>
                        <th>Description</th>
                        <th>Note</th>
                        <th>Adresse</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </thead>
                    <tbody>
                        <br>
                        <a href="CRUD_Entreprise/addEntreprise.php" class="btn_ajout">Ajouter une entreprise</a>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $entreprise){
                        ?>
                        <br>
                            <tr>
                                <td><?= $entreprise['Id_Entreprise'] ?></td>
                                <td><?= $entreprise['N_Entreprise'] ?></td>
                                <td><?= $entreprise['Siret'] ?></td>
                                <td><?= $entreprise['Nb_Etudiant'] ?></td>
                                <td><?= $entreprise['Desc_E'] ?></td>
                                <td><?= $entreprise['Note'] ?></td>
                                <td><?= $entreprise['Numero'] ." ". $entreprise['N_Rue'] ." ". $entreprise['Ville'] ." ". $entreprise['CodeP'] ." ". $entreprise['Departement'] ." ". $entreprise['Region'] ." ". $entreprise['Complement']?></td>
                                <td><a href="CRUD_Entreprise/editEntreprise.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa duotone fa-pencil"></i></a></td> 
                                <td><a href="CRUD_Entreprise/deleteEntreprise.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa solid fa-trash"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
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