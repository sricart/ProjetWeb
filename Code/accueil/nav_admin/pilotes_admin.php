<?php
    session_start();
    require_once('CRUD_Pilote/connect.php');
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
    $sql = 'SELECT `Id_Pilote`,`N_Pilote`,`P_Pilote`,`Login`,`Mdp` 
    FROM pilote 
    INNER JOIN authentifiant 
    ON pilote.ID_Auth = authentifiant.ID_Auth 
    WHERE `Admin`!="1"
    AND `Pilote`!="0";';

    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
    {
        // On inclut la connexion à la base
        require_once('CRUD_Etudiant/connect.php');
        $recherche = $_POST['recherche'];
        // Prépare la requête SQL
        $sql = 'SELECT * 
        FROM `authentifiant` 
        INNER JOIN `pilote` 
        ON authentifiant.Id_Auth = pilote.Id_Auth 
        INNER JOIN `promotion` 
        ON pilote.Id_Pilote = promotion.Id_Pilote 
        INNER JOIN `centre` 
        ON promotion.Id_Centre = centre.Id_Centre 
        WHERE N_Pilote 
        LIKE :recherche 
        OR P_Pilote 
        LIKE :recherche 
        OR centre.Id_Centre 
        LIKE :recherche 
        OR promotion.Id_Promotion 
        LIKE :recherche;';
 
        $query = $db->prepare($sql);
        $query->execute(array(':recherche' => '%' . $recherche . '%'));
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['message'] = '<h3>Résultats de la recherche "' . $recherche . '" </h3>';
        require_once('CRUD_Etudiant/close.php');
    }
    else 
    {
        // On inclut la connexion à la base
        require_once('CRUD_Etudiant/connect.php');
        // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
        $sql = 'SELECT * 
        FROM `authentifiant` 
        INNER JOIN `pilote` 
        ON authentifiant.Id_Auth = pilote.Id_Auth 
        INNER JOIN `promotion` 
        ON pilote.Id_Pilote = promotion.Id_Pilote 
        INNER JOIN `centre` 
        ON promotion.Id_Centre = centre.Id_Centre 
        WHERE `Admin`!="1" 
        AND `Pilote`!="0";';
        // On prépare la requête
        $query = $db->prepare($sql);
        // On exécute la requête
        $query->execute();
        // On stocke le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        require_once('CRUD_Etudiant/close.php');
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://localhost/code/accueil/nav_admin/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Pilote </title>
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
                                    <a href="http://localhost/code/index.php" onclick="return deconnexionConfirm();" >Déconnexion </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <h1>Liste des pilotes</h1>
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
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Liste des promotions</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </thead>
                    <tbody>
                        <a href="http://localhost/Code/accueil/nav_admin/CRUD_Pilote/addAuthEtudiant.php" class="btn_ajout">Ajouter un pilote</a>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $pilote){
                        ?>
                            <tr>
                                <td><?= $pilote['Id_Pilote'] ?></td>
                                <td><?= $pilote['N_Pilote'] ?></td>
                                <td><?= $pilote['P_Pilote'] ?></td>
                                <td><?= $pilote['Login'] ?></td>
                                <td><?= $pilote['Mdp'] ?></td>
                                <td><a href="http://localhost/Code/accueil/nav_admin/afficher_centre.php?Id_Pilote=<?= $pilote['Id_Pilote'] ?>"> <i class="fa solid fa-list"></i></a></td>
                                <td><a href="http://localhost/Code/accueil/nav_admin/CRUD_Pilote/editEtudiant.php?Id_Pilote=<?= $pilote['Id_Pilote'] ?>"><i class="fa duotone fa-pencil"></i></a></td> 
                                <td><a href="http://localhost/Code/accueil/nav_admin/CRUD_Pilote/deleteEtudiant.php?Id_Pilote=<?= $pilote['Id_Pilote'] ?>"><i class="fa solid fa-trash"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            </div>
        </div>

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