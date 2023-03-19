<?php
// On démarre une session

if($_POST)
{
    if(isset($_POST['N_Etudiant']) && !empty($_POST['N_Etudiant'])
    && isset($_POST['P_Etudiant']) && !empty($_POST['P_Etudiant'])
    && isset($_POST['Cv'])
    && isset($_POST['Lettre_Motivation'])
    && isset($_POST['Photo'])
    && isset($_POST['Id_Promotion']) && !empty($_POST['Id_Promotion'])
    && isset($_POST['Id_Pilote']) && !empty($_POST['Id_Pilote']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $nom = strip_tags($_POST['N_Etudiant']);
        $prenom = strip_tags($_POST['P_Etudiant']);
        $cv = strip_tags($_POST['Cv']);
        $lm = strip_tags($_POST['Lettre_Motivation']);
        $photo = strip_tags($_POST['Photo']);
        $promo = strip_tags($_POST['Id_Promotion']);
        $pilote = strip_tags($_POST['Id_Pilote']);
        $auth = strip_tags($_POST['Id_Auth']);

        $sql = 'INSERT INTO `etudiant` (`N_Etudiant`, `P_Etudiant`, `Cv` , `Lettre_Motivation`, `Photo`, `Id_Promotion`, `Id_Pilote`, `Id_Auth`) VALUES (:nom, :prenom, :cv, :lm, :photo, :promo, :pilote, (SELECT MAX(Id_Auth) FROM authentifiant));';
        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':cv', $cv, PDO::PARAM_STR);
        $query->bindValue(':lm', $lm, PDO::PARAM_STR);
        $query->bindValue(':photo', $photo, PDO::PARAM_STR);
        $query->bindValue(':promo', $promo, PDO::PARAM_STR);
        $query->bindValue(':pilote', $pilote, PDO::PARAM_INT);

        $query->execute();

        require_once('close.php');

        header('Location: index.php');
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

                <h1>Ajouter un étudiant</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="N_Etudiant">Nom</label>
                        <input type="text" id="N_Etudiant" name="N_Etudiant" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="P_Etudiant">Prénom</label>
                        <input type="text" id="P_Etudiant" name="P_Etudiant" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Cv">CV</label>
                        <input type="text" id="Cv" name="Cv" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Lettre_motivation">Lettre de motivation</label>
                        <input type="text" id="Lettre_Motivation" name="Lettre_Motivation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Photo">Photo</label>
                        <input type="text" id="Photo" name="Photo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Id_Promotion">Promotion</label>
                        <input type="text" id="Id_Promotion" name="Id_Promotion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Id_Pilote">Pilote</label>
                        <input type="text" id="Id_Pilote" name="Id_Pilote" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>