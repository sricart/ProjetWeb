<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['N_Entreprise']) && !empty($_POST['N_Entreprise'])
    && isset($_POST['Siret']) && !empty($_POST['Siret'])
    && isset($_POST['Desc_E']) && !empty($_POST['Desc_E'])
    && isset($_POST['Nb_Etudiant']) && !empty($_POST['Nb_Etudiant'])
    && isset($_POST['Note']) && !empty($_POST['Note']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $nom = strip_tags($_POST['N_Entreprise']);
        $siret = strip_tags($_POST['Siret']);
        $descrip = strip_tags($_POST['Desc_E']);
        $nbEtudiant = strip_tags($_POST['Nb_Etudiant']);
        $note = strip_tags($_POST['Note']);

        $sql = 'INSERT INTO `entreprise` (`N_Entreprise`, `Siret`, `Desc_E`, `Nb_Etudiant`, `Note`) VALUES (:nom, :siret, :descrip, :nbEtudiant, :note);';
        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':siret', $siret, PDO::PARAM_INT);
        $query->bindValue(':descrip', $descrip, PDO::PARAM_STR);
        $query->bindValue(':nbEtudiant', $nbEtudiant, PDO::PARAM_INT);
        $query->bindValue(':note', $note, PDO::PARAM_INT);

        $query->execute();

        require_once('close.php');

        header('Location: localhost/Code/accueil/nav_admin/entreprises_admin.php');
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
    <title>Ajouter une entreprise</title>

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

                <h1>Ajouter une entreprise</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="N_Entreprise">Nom</label>
                        <input type="text" id="N_Entreprise" name="N_Entreprise" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Siret">N° de siret</label>
                        <input type="text" id="Siret" name="Siret" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Desc_E">Description</label>
                        <input type="text" id="Desc_E" name="Desc_E" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Nb_Etudiant">Nombre d'étudiant en stage dans cette entreprise</label>
                        <input type="text" id="Nb_Etudiant" name="Nb_Etudiant" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Note">Note des pilotes</label>
                        <input type="text" id="Note" name="Note" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>