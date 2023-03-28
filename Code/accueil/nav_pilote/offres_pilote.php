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
        require_once('CRUD_Etudiant/connect.php');

        $recherche = $_POST['recherche'];

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

        $query = $db->prepare($sql);
        $query->execute(array(':recherche' => '%' . $recherche . '%'));
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['message'] = '<h4>Résultats de la recherche "' . $recherche . '" :</h4>';
    }
    else 
    {
        require_once('CRUD_Etudiant/connect.php');
        $sql = 'SELECT * FROM `offre` 
        INNER JOIN `entreprise` ON offre.Id_Entreprise = entreprise.Id_Entreprise 
        INNER JOIN `adresse` ON entreprise.Id_entreprise = adresse.Id_Entreprise
        INNER JOIN pilote ON pilote.Id_Pilote = offre.Id_Pilote;';

        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page avec la liste des offres pour le pilote">
        <meta name="keywords" content="offre pilote">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Offres </title>
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
                        <a href="http://localhost/code/accueil/nav_pilote/accueil_pilote.php">Accueil</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/accueil/nav_pilote/etudiants_pilote.php">Etudiants</a>
                    </li>
                    <li>
                        <a>Entreprises et Offres</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_pilote/entreprises_pilote.php"> Entreprises </a>
                                </li>
                                <li>
                                    <a href="http://localhost/code/accueil/nav_pilote/offres_pilote.php"> Offres </a>
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
            <h1>Liste des offres</h1>
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
                    <input type="text" name="recherche" id="recherche" placeholder="nom, prénom, promotion, centre">
                    <input type="submit" value="Rechercher">
                </form>
            </section>
            <div class="row">
                <section class="col-12">
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
                            <br>
                            <br>
                            <?php
                                foreach($result as $offre){
                            ?>
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