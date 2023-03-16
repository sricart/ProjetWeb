<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['Id_Etudiant'])
    && isset($_POST['N_Etudiant'])
    && isset($_POST['P_Etudiant'])
    && isset($_POST['Cv'])
    && isset($_POST['Lettre_Motivation'])
    && isset($_POST['Photo'])
    && isset($_POST['Id_Promotion'])
    && isset($_POST['Id_Pilote'])
    && isset($_POST['Id_Auth'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['Id_Etudiant']);
        $nom = strip_tags($_POST['N_Etudiant']);
        $prenom = strip_tags($_POST['P_Etudiant']);
        $cv = strip_tags($_POST['Cv']);
        $lm = strip_tags($_POST['Lettre_Motivation']);
        $photo = strip_tags($_POST['Photo']);
        $promo = strip_tags($_POST['Id_Promotion']);
        $pilote = strip_tags($_POST['Id_Pilote']);
        $auth = strip_tags($_POST['Id_Auth']);

        $sql = 'UPDATE `etudiant` SET `N_Etudiant`=:nom, `P_Etudiant`=:prenom, `Cv`=:cv, `Lettre_Motivation`=:lm, `Photo`=:photo, `Id_Promotion`=:promo, `Id_Pilote`=:pilote, `Id_Auth`=:auth WHERE `Id_Etudiant`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':cv', $cv, PDO::PARAM_STR);
        $query->bindValue(':lm', $lm, PDO::PARAM_STR);
        $query->bindValue(':photo', $photo, PDO::PARAM_STR);
        $query->bindValue(':promo', $promo, PDO::PARAM_STR);
        $query->bindValue(':pilote', $pilote, PDO::PARAM_INT);
        $query->bindValue(':auth', $auth, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Etudiant modifié";
        require_once('close.php');

        header('Location: index.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Etudiant']) && !empty($_GET['Id_Etudiant'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Etudiant']);

    $sql = 'SELECT * FROM `etudiant` WHERE `Id_Etudiant` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $etudiant = $query->fetch();

    // On vérifie si le produit existe
    if(!$etudiant){
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
                <h1>Ajouter un produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="N_Etudiant">Nom</label>
                        <input type="text" id="N_Etudiant" name="N_Etudiant" class="form-control" value="<?= $etudiant['N_Etudiant']?>">
                    </div>
                    <div class="form-group">
                        <label for="P_Etudiant">Prénom</label>
                        <input type="text" id="P_Etudiant" name="P_Etudiant" class="form-control" value="<?= $etudiant['P_Etudiant']?>">
                    </div>
                    <div class="form-group">
                        <label for="Cv">CV</label>
                        <input type="text" id="Cv" name="Cv" class="form-control" value="<?= $etudiant['Cv']?>">
                    </div>
                    <div class="form-group">
                        <label for="Lettre_motivation">Lettre</label>
                        <input type="text" id="Lettre_Motivation" name="Lettre_Motivation" class="form-control" value="<?= $etudiant['Lettre_Motivation']?>">
                    </div>
                    <div class="form-group">
                        <label for="Photo">Photo</label>
                        <input type="text" id="Photo" name="Photo" class="form-control" value="<?= $etudiant['Photo']?>">
                    </div>
                    <div class="form-group">
                        <label for="Id_Promotion">Promotion</label>
                        <input type="text" id="Id_Promotion" name="Id_Promotion" class="form-control" value="<?= $etudiant['Id_Promotion']?>">
                    </div>
                    <div class="form-group">
                        <label for="Id_Pilote">Pilote</label>
                        <input type="text" id="Id_Pilote" name="Id_Pilote" class="form-control" value="<?= $etudiant['Id_Pilote']?>">
                    </div>
                    <div class="form-group">
                        <label for="Id_Auth">Authentifiant</label>
                        <input type="text" id="Id_Auth" name="Id_Auth" class="form-control" value="<?= $etudiant['Id_Auth']?>">
                    </div>
                    <input type="hidden" value="<?= $etudiant['Id_Etudiant']?>" name="Id_Etudiant">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
