<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['Login']) && !empty($_POST['Login'])
    && isset($_POST['Mdp']) && !empty($_POST['Mdp']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $log = strip_tags($_POST['Login']);
        $mdp = strip_tags($_POST['Mdp']);

        $sql = 'INSERT INTO `authentifiant` (`Login`, `Mdp`, `Admin` , `Pilote`) VALUES (:log, :mdp, "0", "1");';
        $query = $db->prepare($sql);

        $query->bindValue(':log', $log, PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);

        $query->execute();

        require_once('close.php');
        $_SESSION['message'] = "Pilote ajouté";
        header('Location: http://localhost/Code/accueil/nav_admin/CRUD_Pilote/addEtudiant.php');
    }
    else
    {
        $_SESSION['erreur'] = "Login incomplet";
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

                <h1>Création du login</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="Login">Email</label>
                        <input type="text" id="Login" name="Login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Mdp">Mot de passe</label>
                        <input type="text" id="Mdp" name="Mdp" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>

