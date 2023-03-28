<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['Numero']) && !empty($_POST['Numero'])
    && isset($_POST['N_Rue']) && !empty($_POST['N_Rue'])
    && isset($_POST['zipcode']) && !empty($_POST['zipcode'])
    && isset($_POST['city']) && !empty($_POST['city'])
    && isset($_POST['Departement']) && !empty($_POST['Departement'])
    && isset($_POST['Region']) && !empty($_POST['Region'])
    && isset($_POST['Complement']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $numero = strip_tags($_POST['Numero']);
        $rue = strip_tags($_POST['N_Rue']);
        $codep = strip_tags($_POST['zipcode']);
        $ville = strip_tags($_POST['city']);
        $dep = strip_tags($_POST['Departement']);
        $region = strip_tags($_POST['Region']);
        $compl = strip_tags($_POST['Complement']);
        $entreprise = strip_tags($_POST['Id_Entreprise']);

        $sql = 'INSERT INTO `adresse` (`Numero`, `N_Rue`, `CodeP`, `Ville`, `Departement`, `Region`, `Complement`, `Id_Entreprise`) 
        VALUES (:numero, :rue, :codep, :ville, :dep, :region, :compl, (SELECT MAX(Id_Entreprise) FROM `entreprise`));';
        $query = $db->prepare($sql);

        $query->bindValue(':numero', $numero, PDO::PARAM_INT);
        $query->bindValue(':rue', $rue, PDO::PARAM_STR);
        $query->bindValue(':codep', $codep, PDO::PARAM_INT);
        $query->bindValue(':ville', $ville, PDO::PARAM_STR);
        $query->bindValue(':dep', $dep, PDO::PARAM_STR);
        $query->bindValue(':region', $region, PDO::PARAM_STR);
        $query->bindValue(':compl', $compl, PDO::PARAM_STR);

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
    <title>Ajouter une adresse</title>

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

                <h1>Ajouter une adresse</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="Numero">Numéro</label>
                        <input type="text" id="Numero" name="Numero" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="N_Rue">Rue</label>
                        <input type="text" id="N_Rue" name="N_Rue" class="form-control">
                    </div>
                    <div class="form-group">
				    <label for="zipcode">Code Postal</label>
				    <input type="text" name="zipcode" class="form-control" placeholder="Code postal" id="zipcode">
				    <div style="display: none; color: #f55;" id="error-message"></div>
				    </div>
				    <div class="form-group">
				        <label for="city">Ville</label>
				        <select class="form-control" name="city" id="city">

				        </select>
				    </div>
                    <div class="form-group">
                        <label for="Departement">Département</label>
                        <input type="text" id="Departement" name="Departement" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Region">Région</label>
                        <input type="text" id="Region" name="Region" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Complement">Complément d'adresse</label>
                        <input type="text" id="Complement" name="Complement" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="script.js"></script>
</body>
</html>