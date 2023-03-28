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
    echo '<h6>Résultats de la recherche "' . $recherche . '" :</h6>';

    require_once('close.php');
}
else 
{
    // On inclut la connexion à la base
    require_once('connect.php');

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

    echo '<h1>Liste des offres</h1>';

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


                <!-- Formulaire pour saisir le nom à rechercher -->
                <form method="POST">
                    <label for="recherche">Rechercher :</label>
                    <input type="text" name="recherche" id="recherche" placeholder="nom, prénom, promotion, centre">
                    <input type="submit" value="Rechercher">
                </form>

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
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <br>
                        <a href="addOffre.php" class="btn btn-primary">Ajouter une offre</a>
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
                                <td><a href="editOffre.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa solid fa-pen"></i></a></td> 
                                <td><a href="deleteOffre.php?Id_Offre=<?= $offre['Id_Offre'] ?>"><i class="fa solid fa-trash"></i></a></td>
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
