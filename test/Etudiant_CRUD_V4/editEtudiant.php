<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['Id_Etudiant'])
    && isset($_POST['N_Etudiant'])
    && isset($_POST['P_Etudiant'])
    && isset($_POST['Id_Promotion'])
    && isset($_POST['Login'])
    && isset($_POST['Mdp'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['Id_Etudiant']);
        $nom = strip_tags($_POST['N_Etudiant']);
        $prenom = strip_tags($_POST['P_Etudiant']);
        $promo = strip_tags($_POST['Id_Promotion']);
        $log = strip_tags($_POST['Login']);
        $mdp = strip_tags($_POST['Mdp']);

        $sql = 'UPDATE `etudiant` INNER JOIN `authentifiant` ON etudiant.Id_Auth = authentifiant.Id_Auth SET `N_Etudiant`=:nom, `P_Etudiant`=:prenom, `Id_Promotion`=:promo, `Login`=:log, `Mdp`=:mdp WHERE `Id_Etudiant`= :id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':promo', $promo, PDO::PARAM_STR);
        $query->bindValue(':log', $log, PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);

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

    $sql = 'SELECT * FROM `etudiant` INNER JOIN authentifiant ON etudiant.Id_Auth = authentifiant.Id_Auth WHERE `Id_Etudiant` = :id;';

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
                        <label for="Id_Promotion">Promotion</label>
                        <input type="text" id="Id_Promotion" name="Id_Promotion" class="form-control" value="<?= $etudiant['Id_Promotion']?>">
                    </div>
                    <div class="form-group">
                        <label for="Login">Email</label>
                        <input type="text" id="Login" name="Login" class="form-control" value="<?= $etudiant['Login']?>">
                    </div>
                    <div class="form-group">
                        <label for="Mdp">Mot de passe</label>
                        <input type="text" id="Mdp" name="Mdp" class="form-control" value="<?= $etudiant['Mdp']?>">
                    </div>
                    <input type="hidden" value="<?= $etudiant['Id_Etudiant']?>" name="Id_Etudiant">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
