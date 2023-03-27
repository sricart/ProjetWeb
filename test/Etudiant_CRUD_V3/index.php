<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

// Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
$sql = 'SELECT * FROM `authentifiant` INNER JOIN `etudiant` ON authentifiant.Id_Auth = etudiant.Id_Auth INNER JOIN `promotion` ON etudiant.Id_Promotion = promotion.Id_Promotion INNER JOIN `centre` ON promotion.Id_Centre = centre.Id_Centre WHERE `Admin`!="1" AND `Pilote`!="1";';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
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
                <h1>Liste des étudiants</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Promotion</th>
                        <th>Centre</th>
                        <th>CV</th>
                        <th>Lettre de motivation</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <br>
                        <a href="addAuthEtudiant.php" class="btn btn-primary">Ajouter un étudiant</a>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $etudiant){
                        ?>
                        <br>
                            <tr>
                                <td><?= $etudiant['Id_Etudiant'] ?></td>
                                <td><?= $etudiant['N_Etudiant'] ?></td>
                                <td><?= $etudiant['P_Etudiant'] ?></td>
                                <td><?= $etudiant['Id_Promotion'] ?></td>
                                <td><?= $etudiant['Id_Centre'] ?></td>
                                <td><?= $etudiant['Cv'] ?></td>
                                <td><?= $etudiant['Lettre_Motivation'] ?></td>
                                <td><?= '<img src="data:image/jpeg/png;base64,' .base64_encode($etudiant['Photo']). '" style="width: 50px; height: 50px;" >'?></td>
                                <td><?= $etudiant['Login'] ?></td>
                                <td><?= $etudiant['Mdp'] ?></td>
                                <td><a href="editEtudiant.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>"><i class="fa solid fa-pen"></i></a></td> 
                                <td><a href="deleteEtudiant.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>"><i class="fa solid fa-trash"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>