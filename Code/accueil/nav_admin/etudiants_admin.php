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
    $sql = 'SELECT `Id_Etudiant`,`N_Etudiant`,`P_Etudiant`,`Cv`,`Lettre_Motivation`,`Photo`,`Id_Promotion`,`Login`,`Mdp` FROM etudiant INNER JOIN authentifiant ON etudiant.ID_Auth = authentifiant.ID_Auth WHERE `Admin`!="1" AND `Pilote`!="1";';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
    {
        require_once('CRUD_Etudiant/connect.php');
        $recherche = $_POST['recherche'];
        $sql = 'SELECT * 
        FROM `authentifiant` 
        INNER JOIN `etudiant` 
        ON authentifiant.Id_Auth = etudiant.Id_Auth 
        INNER JOIN `promotion` 
        ON etudiant.Id_Promotion = promotion.Id_Promotion 
        INNER JOIN `centre` 
        ON promotion.Id_Centre = centre.Id_Centre 
        WHERE N_Etudiant 
        LIKE :recherche 
        OR P_Etudiant 
        LIKE :recherche 
        OR promotion.Id_Centre 
        LIKE :recherche 
        OR etudiant.Id_Promotion 
        LIKE :recherche;';

        $query = $db->prepare($sql);
        $query->execute(array(':recherche' => '%' . $recherche . '%'));
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['message'] = '<h3>Résultats de la recherche "' . $recherche . '" </h3>';

        require_once('CRUD_Etudiant/close.php');
    }
    else 
    {
        require_once('CRUD_Etudiant/connect.php');
        $sql = 'SELECT *
        FROM `authentifiant` 
        INNER JOIN `etudiant` 
        ON authentifiant.Id_Auth = etudiant.Id_Auth 
        INNER JOIN `promotion` 
        ON etudiant.Id_Promotion = promotion.Id_Promotion 
        INNER JOIN `centre` 
        ON promotion.Id_Centre = centre.Id_Centre 
        WHERE `Admin`!="1" 
        AND `Pilote`!="1";';

        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        require_once('CRUD_Etudiant/close.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Page des étudiants pour l'admin">
        <meta name="keywords" content="etudiant admin">
        <meta name="author" content="Groupe 2">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://localhost/code/accueil/nav_admin/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Etudiants </title>
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
            <div class="logo"> <img src="http://localhost/code/image/logo.png" alt="fr"></div>
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
                                    <a href="http://localhost/code/index.php" onclick="return deconnexionConfirm();" >Déconnexion </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <br>

        <main>
            <h1>Liste des étudiants</h1>
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
            <br>
            <div class="container">
                <div class="row">
                    <section class="col-12">
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>CV</th>
                                <th>Lettre de motivation</th>
                                <th>Photo</th>
                                <th>Promotion</th>
                                <th>Email</th>
                                <th>Mot de passe</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </thead>
                            <tbody>
                                <a href="http://localhost/Code/accueil/nav_admin/CRUD_Etudiant/addAuthEtudiant.php" class="btn_ajout">Ajouter un étudiant</a>
                                <?php
                                    foreach($result as $etudiant){
                                ?>
                                    <tr>
                                        <td><?= $etudiant['Id_Etudiant'] ?></td>
                                        <td><?= $etudiant['N_Etudiant'] ?></td>
                                        <td><?= $etudiant['P_Etudiant'] ?></td>
                                        <td><?= $etudiant['Cv'] ?></td>
                                        <td><?= $etudiant['Lettre_Motivation'] ?></td>
                                        <td><?= $etudiant['Photo'] ?></td>
                                        <td><?= $etudiant['Id_Promotion'] ?></td>
                                        <td><?= $etudiant['Login'] ?></td>
                                        <td><?= $etudiant['Mdp'] ?></td>
                                        <td><a href="http://localhost/Code/accueil/nav_admin/CRUD_Etudiant/editEtudiant.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>"><i class="fa duotone fa-pencil"></i></a></td> 
                                        <td><a href="http://localhost/Code/accueil/nav_admin/CRUD_Etudiant/deleteEtudiant.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>"><i class="fa solid fa-trash"></i></a></td>
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