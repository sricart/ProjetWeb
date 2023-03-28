<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['Id_Offre'])
    && isset($_POST['N_Entreprise'])
    & isset($_POST['N_Offre'])
    && isset($_POST['Statut_offre'])
    && isset($_POST['Desc_Offre'])
    && isset($_POST['Duree'])
    && isset($_POST['Remuneration'])
    && isset($_POST['Date_Pub'])
    && isset($_POST['N_Pilote'])
    && isset($_POST['Anne2'])
    && isset($_POST['Anne3'])
    && isset($_POST['Anne4'])
    && isset($_POST['Anne5'])){

        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['Id_Offre']);
        $entreprise = strip_tags($_POST['N_Entreprise']);
        $offre = strip_tags($_POST['N_Offre']);
        $statut = strip_tags($_POST['Statut_offre']);
        $descrip = strip_tags($_POST['Desc_Offre']);
        $duree = strip_tags($_POST['Duree']);
        $remun = strip_tags($_POST['Remuneration']);
        $dateParu = strip_tags($_POST['Date_Pub']);
        $pilote = strip_tags($_POST['N_Pilote']);
        $annee2 = strip_tags($_POST['Anne2']);
        $annee3 = strip_tags($_POST['Anne3']);
        $annee4 = strip_tags($_POST['Anne4']);
        $annee5 = strip_tags($_POST['Anne5']);

        $sql = 'UPDATE `entreprise` 
        INNER JOIN `offre` ON entreprise.Id_Entreprise = offre.Id_Entreprise 
        INNER JOIN pilote ON pilote.Id_Pilote = offre.Id_Pilote
        SET  `N_Entreprise`=:entreprise, `N_Offre`=:offre, `Statut_Offre`=:statut, `Desc_Offre`=:descrip, `Duree`=:duree, `Remuneration`=:remun,  
        `Date_Pub`=:dateParu,  `N_Pilote`=:pilote,  `Anne2`=:annee2,  `Anne3`=:annee3,  `Anne4`=:annee4,  `Anne5`=:annee5 
        WHERE `Id_Offre`= :id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
        $query->bindValue(':offre', $offre, PDO::PARAM_STR);
        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':descrip', $descrip, PDO::PARAM_STR);
        $query->bindValue(':duree', $duree, PDO::PARAM_STR);
        $query->bindValue(':remun', $remun, PDO::PARAM_STR);
        $query->bindValue(':dateParu', $dateParu, PDO::PARAM_STR);
        $query->bindValue(':pilote', $pilote, PDO::PARAM_STR);
        $query->bindValue(':annee2', $annee2, PDO::PARAM_INT);
        $query->bindValue(':annee3', $annee3, PDO::PARAM_INT);
        $query->bindValue(':annee4', $annee4, PDO::PARAM_INT);
        $query->bindValue(':annee5', $annee5, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Offre modifiée";
        require_once('close.php');

        header('Location: index.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Offre']) && !empty($_GET['Id_Offre'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Offre']);

    $sql = 'SELECT * FROM `entreprise` 
    INNER JOIN `offre` ON entreprise.Id_Entreprise = offre.Id_Entreprise 
    INNER JOIN pilote ON pilote.Id_Pilote = offre.Id_Pilote
    WHERE `Id_Offre`= :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $offre = $query->fetch();

    // On vérifie si le produit existe
    if(!$offre){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>

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
                <h1>Modifier une offre</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="N_Entreprise">Nom de l'entreprise</label>
                        <input type="text" id="N_Entreprise" name="N_Entreprise" class="form-control" value="<?= $offre['N_Entreprise']?>">
                    </div>
                    <div class="form-group">
                        <label for="Statut_offre">Statut de l'offre</label>
                        <input type="text" id="Statut_offre" name="Statut_offre" class="form-control" value="<?= $offre['Statut_offre']?>">
                    </div>
                    <div class="form-group">
                        <label for="N_Offre">Nom de l'offre</label>
                        <input type="text" id="N_Offre" name="N_Offre" class="form-control" value="<?= $offre['N_Offre']?>">
                    </div>
                    <div class="form-group">
                        <label for="Desc_Offre">Description de l'offre</label>
                        <input type="text" id="Desc_Offre" name="Desc_Offre" class="form-control" value="<?= $offre['Desc_Offre']?>">
                    </div>
                    <div class="form-group">
                        <label for="Duree">Durée</label>
                        <input type="text" id="Duree" name="Duree" class="form-control" value="<?= $offre['Duree']?>">
                    </div>
                    <div class="form-group">
                        <label for="Anne2">Année 2</label>
                        <input type="text" id="Anne2" name="Anne2" class="form-control" value="<?= $offre['Anne2']?>">
                    </div>
                    <div class="form-group">
                        <label for="Anne3">Année 3</label>
                        <input type="text" id="Anne3" name="Anne3" class="form-control" value="<?= $offre['Anne3']?>">
                    </div>
                    <div class="form-group">
                        <label for="Anne4">Année 4</label>
                        <input type="text" id="Anne4" name="Anne4" class="form-control" value="<?= $offre['Anne4']?>">
                    </div>
                    <div class="form-group">
                        <label for="Anne5">Année 5</label>
                        <input type="text" id="Anne5" name="Anne5" class="form-control" value="<?= $offre['Anne5']?>">
                    </div>
                    <div class="form-group">
                        <label for="Remuneration">Remuneration</label>
                        <input type="text" id="Remuneration" name="Remuneration" class="form-control" value="<?= $offre['Remuneration']?>">
                    </div>
                    <div class="form-group">
                        <label for="Date_Pub">Date de publication de l'offre</label>
                        <input type="text" id="Date_Pub" name="Date_Pub" class="form-control" value="<?= $offre['Date_Pub']?>">
                    </div>
                    <div class="form-group">
                        <label for="N_Pilote">Pilote</label>
                        <input type="text" id="N_Pilote" name="N_Pilote" class="form-control" value="<?= $offre['N_Pilote']?>">
                    </div>
                    <div class="form-group">
                        <label for="Id_Entreprise">Entreprise</label>
                        <input type="text" id="Id_Entreprise" name="Id_Entreprise" class="form-control" value="<?= $offre['N_Entreprise']?>">
                    </div>
                    <input type="hidden" value="<?= $offre['Id_Offre']?>" name="Id_Offre">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
