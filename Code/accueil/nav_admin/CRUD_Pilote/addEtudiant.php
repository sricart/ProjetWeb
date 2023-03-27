<?php
// On démarre une session

if($_POST)
{
    if(isset($_POST['N_Pilote']) && !empty($_POST['N_Pilote']) 
    && isset($_POST['P_Pilote']) && !empty($_POST['P_Pilote']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $nom = strip_tags($_POST['N_Pilote']);
        $prenom = strip_tags($_POST['P_Pilote']);
        $auth = strip_tags($_POST['Id_Auth']);

        $sql = 'INSERT INTO `pilote` (`N_Pilote`, `P_Pilote`, `Id_Auth`) VALUES (:nom, :prenom, (SELECT MAX(Id_Auth) FROM authentifiant));';
        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);

        $query->execute();

        require_once('close.php');

        header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
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
                        <input type="text" id="N_Pilote" name="N_Pilote" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="P_Etudiant">Prénom</label>
                        <input type="text" id="P_Pilote" name="P_Pilote" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>