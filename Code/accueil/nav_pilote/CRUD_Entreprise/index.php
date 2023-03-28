<?php

// On démarre une session
session_start();

// Vérifie si un numéro d'étudiant a été saisi dans le formulaire
if (isset($_POST['recherche']) && !empty(isset($_POST['recherche'])))
{

    // On inclut la connexion à la base
    require_once('connect.php');

    $recherche = $_POST['recherche'];

    // Prépare la requête SQL
    $sql = 'SELECT * FROM `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise WHERE N_Entreprise LIKE :recherche OR Ville LIKE :recherche OR Region LIKE :recherche OR Departement LIKE :recherche OR Desc_E LIKE :recherche;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute la requête
    $query->execute(array(':recherche' => '%' . $recherche . '%'));
    

    // On stocke le résultat dans un tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Affiche les résultats de la recherche
    echo '<h6>Résultats de la recherche "' . $recherche . '" :</h6>';

    require_once('close.php');
}
else 
{
    // On inclut la connexion à la base
    require_once('connect.php');

    // Selectionne les infos importantes pour l'admin concernant les etudiants donc admin et pilote !=1
    $sql = 'SELECT * FROM `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute la requête
    $query->execute();

    // On stocke le résultat dans un tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

    echo '<h1>Liste des entreprises</h1>';

require_once('close.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des entreprises</title>
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


                <!-- Formulaire pour saisir le nom à rechercher -->
                <form method="POST">
                    <label for="recherche">Rechercher :</label>
                    <input type="text" name="recherche" id="recherche" placeholder="nom, ville, région, département, secteur">
                    <input type="submit" value="Rechercher">
                </form>

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
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <br>
                        <a href="addEntreprise.php" class="btn btn-primary">Ajouter une entreprise</a>
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
                                <td><a href="editEntreprise.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa solid fa-pen"></i></a></td> 
                                <td><a href="deleteEntreprise.php?Id_Entreprise=<?= $entreprise['Id_Entreprise'] ?>"><i class="fa solid fa-trash"></i></a></td>
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
