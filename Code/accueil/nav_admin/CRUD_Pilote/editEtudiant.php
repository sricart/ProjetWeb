<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['Id_Pilote'])
    && isset($_POST['N_Pilote'])
    && isset($_POST['P_Pilote'])
    && isset($_POST['Login'])
    && isset($_POST['Mdp'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['Id_Pilote']);
        $nom = strip_tags($_POST['N_Pilote']);
        $prenom = strip_tags($_POST['P_Pilote']);
        $log = strip_tags($_POST['Login']);
        $mdp = strip_tags($_POST['Mdp']);

        $sql = 'UPDATE `pilote` INNER JOIN `authentifiant` ON pilote.Id_Auth = authentifiant.Id_Auth SET `N_Pilote`=:nom, `P_Pilote`=:prenom, `Login`=:log, `Mdp`=:mdp WHERE `Id_Pilote`= :id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':log', $log, PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Pilote modifié";
        require_once('close.php');

        header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Pilote']) && !empty($_GET['Id_Pilote'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Pilote']);

    $sql = 'SELECT * FROM `pilote` INNER JOIN authentifiant ON pilote.Id_Auth = authentifiant.Id_Auth WHERE `Id_Pilote` = :id;';

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
        header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
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
                        <input type="text" id="N_Pilote" name="N_Pilote" class="form-control" value="<?= $etudiant['N_Pilote']?>">
                    </div>
                    <div class="form-group">
                        <label for="P_Etudiant">Prénom</label>
                        <input type="text" id="P_Pilote" name="P_Pilote" class="form-control" value="<?= $etudiant['P_Pilote']?>">
                    </div>
                    <div class="form-group">
                        <label for="Login">Email</label>
                        <input type="text" id="Login" name="Login" class="form-control" value="<?= $etudiant['Login']?>">
                    </div>
                    <div class="form-group">
                        <label for="Mdp">Mot de passe</label>
                        <input type="text" id="Mdp" name="Mdp" class="form-control" value="<?= $etudiant['Mdp']?>">
                    </div>
                    <input type="hidden" value="<?= $etudiant['Id_Pilote']?>" name="Id_Pilote">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
