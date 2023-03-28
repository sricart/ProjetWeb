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

    if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
    {
        // On inclut la connexion à la base
        require_once('CRUD_Etudiant/connect.php');

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
        $_SESSION['message'] = '<h4>Résultats de la recherche "' . $recherche . '" :</h4>';
    }
    else 
    {
        // On inclut la connexion à la base
        require_once('CRUD_Etudiant/connect.php');
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
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
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

        <main>
            <h1>Liste des offres</h1>
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
        <form method="POST">
                    <label for="recherche">Rechercher :</label>
                    <input type="text" name="recherche" id="recherche" placeholder="nom, prénom, promotion, centre">
                    <input type="submit" value="Rechercher">
                </form>
        </section>
        <div class="row">
            <section class="col-12">

                <!-- Affichage des résultats -->
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Statut_Offre</th>
                        <th>Type</th>
                        <th>Entreprise</th>
                        <th>Description de l'offre</th>
                        <th>Adresse</th>
                        <th>Durée</th>
                        <th>Niveau attendu</th>
                        <th>rémunération</th>
                        <th>Date de l'offre</th>
                        <th>Pilote</th>
                        <th>Voir</th>
                        <th>Supprimer</th>
                    </thead>
                    <tbody>
                        <br>
                        <a href="CRUD_Offre/addOffre.php" class="btn_ajout">Ajouter une offre</a>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $offre){
                        ?>
                        <br>
                            <tr>
                                <td><?= $offre['Id_Offre'] ?></td>
                                <td><?= $offre['Statut_offre'] ?></td>
                                <td><?= $offre['N_Offre'] ?></td>
                                <td><?= $offre['N_Entreprise'] ?></td>
                                <td><?= $offre['Desc_Offre'] ?></td>
                                <td><?= $offre['Numero'] ." ". $offre['N_Rue'] ." ". $offre['Ville'] ." ". $offre['CodeP'] ." ". $offre['Departement'] ." ". $offre['Region'] ." ". $offre['Complement']?></td>
                                <td><?= $offre['Duree'] ?></td>
                                <td><?php
                                        if ($offre['Anne2'] == 1) {
                                            echo "<p>Années 2 </p>";
                                        }
                                        if ($offre['Anne3'] == 1) {
                                            echo "<p>Années 3 </p>";
                                        }
                                        if ($offre['Anne4'] == 1) {
                                            echo "<p>Années 4 </p>";
                                        }
                                        if ($offre['Anne5'] == 1) {
                                            echo "<p>Années 5 </p>";
                                        }?></td>
                                <td><?= $offre['Remuneration'] ?></td>
                                <td><?= $offre['Date_Pub'] ?></td>
                                <td><?= $offre['N_Pilote'] ?></td>
                                <td><a href="CRUD_Offre/editOffre.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa duotone fa-pencil"></i></a></td> 
                                <td><a href="CRUD_Offre/deleteOffre.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa solid fa-trash"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    </main>

        <br>

        <footer>
            <ul>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
        <script src="http://localhost/B4/Projet/L3/code/accueil/nav_admin/app.js"> </script>
    </body>
</html>