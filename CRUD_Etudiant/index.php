<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM etudiant INNER JOIN authentifiant ON etudiant.ID_Auth = authentifiant.ID_Auth';

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
    <title>Liste des produits</title>
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
                        <th>CV</th>
                        <th>Lettre de motivation</th>
                        <th>Photo</th>
                        <th>Promotion</th>
                        <th>Pilote</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Admin</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </thead>
                    <tbody>

                        <?php
                        // On boucle sur la variable result
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
                                <td><?= $etudiant['Id_Pilote'] ?></td>
                                <td><?= $etudiant['Login'] ?></td>
                                <td><?= $etudiant['Mdp'] ?></td>
                                <td><?= $etudiant['Admin'] ?></td>
                                <td><a href="edit.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>">Modi</a></td> 
                                <td><a href="delete.php?Id_Etudiant=<?= $etudiant['Id_Etudiant'] ?>">Supp</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un étudiant</a>
            </section>
        </div>
    </main>
</body>
</html>