<?php
// On démarre une session

if($_POST)
{
    if(isset($_POST['Statut_Offre']) && !empty($_POST['Statut_Offre'])
    && isset($_POST['N_Offre']) && !empty($_POST['N_Offre'])
    && isset($_POST['Desc_Offre']) && !empty($_POST['Desc_Offre'])
    && isset($_POST['Duree']) && !empty($_POST['Duree'])
    && isset($_POST['Anne2'])
    && isset($_POST['Anne3'])
    && isset($_POST['Anne4'])
    && isset($_POST['Anne5'])
    && isset($_POST['Recommandation']) && !empty($_POST['Recommandation'])
    && isset($_POST['Remuneration']) && !empty($_POST['Remuneration'])
    && isset($_POST['Date_Pub']) && !empty($_POST['Date_Pub'])
    && isset($_POST['Id_Pilote']) && !empty($_POST['Id_Pilote'])
    && isset($_POST['Id_Entreprise']) && !empty($_POST['Id_Entreprise']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $statut = strip_tags($_POST['Statut_Offre']);
        $offre = strip_tags($_POST['N_Offre']);
        $descrip = strip_tags($_POST['Desc_Offre']);
        $duree = strip_tags($_POST['Duree']);
        $annee2 = strip_tags($_POST['Anne2']);
        $annee3 = strip_tags($_POST['Anne3']);
        $annee4 = strip_tags($_POST['Anne4']);
        $annee5 = strip_tags($_POST['Anne5']);
        $recommandation = strip_tags($_POST['Recommandation']);
        $remuneration = strip_tags($_POST['Remuneration']);
        $dateP = strip_tags($_POST['Date_Pub']);
        $pilote = strip_tags($_POST['Id_Pilote']);
        $entreprise = strip_tags($_POST['Id_Entreprise']);
        

        $sql = 'INSERT INTO `offre` 
        (`Statut_Offre`, `N_Offre`, `Desc_Offre`, `Duree`, `Anne2`, `Anne3`, `Anne4`, `Anne5`, `Recommandation`, `Remuneration`, `Date_Pub`, Id_Pilote, Id_Entreprise) 
        VALUES (:statut, :offre, :descrip, :duree, :annee2, :annee3, :annee4, :annee5, :recommandation, :remuneration, :dateP, :pilote, :entreprise);';

        $query = $db->prepare($sql);

        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':offre', $offre, PDO::PARAM_STR);
        $query->bindValue(':descrip', $descrip, PDO::PARAM_STR);
        $query->bindValue(':duree', $duree, PDO::PARAM_STR);
        $query->bindValue(':annee2', $annee2, PDO::PARAM_INT);
        $query->bindValue(':annee3', $annee3, PDO::PARAM_INT);
        $query->bindValue(':annee4', $annee4, PDO::PARAM_INT);
        $query->bindValue(':annee5', $annee5, PDO::PARAM_INT);
        $query->bindValue(':recommandation', $recommandation, PDO::PARAM_STR);
        $query->bindValue(':remuneration', $remuneration, PDO::PARAM_STR);
        $query->bindValue(':dateP', $dateP, PDO::PARAM_STR);
        $query->bindValue(':pilote', $pilote, PDO::PARAM_STR);
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);

        $query->execute();

        require_once('close.php');

        header('Location: http://localhost/code/accueil/nav_admin/offres_admin.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une offre</title>

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

                <h1>Ajouter une offre</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="Statut_Offre">Statut de l'offre</label>
                        <input type="text" id="Statut_Offre" name="Statut_Offre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="N_Offre">Nom de l'offre</label>
                        <input type="text" id="N_Offre" name="N_Offre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for=Id_Entreprise">Nom de l'entreprise</label>
                        <input type="text" id="Id_Entreprise" name="Id_Entreprise" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Desc_Offre">Description</label>
                        <input type="text" id="Desc_Offre" name="Desc_Offre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Duree">Durée du stage</label>
                        <input type="text" id="Duree" name="Duree" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Anne2">Année 2</label>
                        <input type="number" id="Anne2" name="Anne2" class="form-control" placeholder="0 ou 1">
                    </div>
                    <div class="form-group">
                        <label for="Anne3">Année 3</label>
                        <input type="number" id="Anne3" name="Anne3" class="form-control" placeholder="0 ou 1">
                    </div>
                    <div class="form-group">
                        <label for="Anne4">Année 4</label>
                        <input type="number" id="Anne4" name="Anne4" class="form-control" placeholder="0 ou 1">
                    </div>
                    <div class="form-group">
                        <label for="Anne5">Année 5</label>
                        <input type="number" id="Anne5" name="Anne5" class="form-control" placeholder="0 ou 1">
                    </div>
                    <div class="form-group">
                        <label for="Recommandation">Recommandation</label>
                        <input type="text" id="Recommandation" name="Recommandation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Remuneration">Rémunération</label>
                        <input type="text" id="Remuneration" name="Remuneration" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Date_Pub">Date de publication de l'offre</label>
                        <input type="text" id="Date_Pub" name="Date_Pub" class="form-control" placeholder="annee-mois-jour">
                    </div>
                    <div class="form-group">
                        <label for="Id_Pilote">Nom du pilote (qui crée l'offre)</label>
                        <input type="text" id="Id_Pilote" name="Id_Pilote" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>