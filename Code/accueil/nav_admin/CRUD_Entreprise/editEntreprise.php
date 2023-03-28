<?php
// On démarre une session
session_start();

if($_POST)
{
    if(isset($_POST['Id_Entreprise']) && !empty($_POST['Id_Entreprise'])
    && isset($_POST['N_Entreprise']) && !empty($_POST['N_Entreprise'])
    && isset($_POST['Siret']) && !empty($_POST['Siret'])
    && isset($_POST['Desc_E']) && !empty($_POST['Desc_E'])
    && isset($_POST['Nb_Etudiant']) && !empty($_POST['Nb_Etudiant'])
    && isset($_POST['Note']) && !empty($_POST['Note'])
    && isset($_POST['Numero']) && !empty($_POST['Numero'])
    && isset($_POST['N_Rue']) && !empty($_POST['N_Rue'])
    && isset($_POST['CodeP']) && !empty($_POST['CodeP'])
    && isset($_POST['Ville']) && !empty($_POST['Ville'])
    && isset($_POST['Departement']) && !empty($_POST['Departement'])
    && isset($_POST['Region']) && !empty($_POST['Region'])
    && isset($_POST['Complement']))
    {
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['Id_Entreprise']);
        $nom = strip_tags($_POST['N_Entreprise']);
        $siret = strip_tags($_POST['Siret']);
        $descrip = strip_tags($_POST['Desc_E']);
        $nbEtudiant = strip_tags($_POST['Nb_Etudiant']);
        $note = strip_tags($_POST['Note']);
        $numero = strip_tags($_POST['Numero']);
        $rue = strip_tags($_POST['N_Rue']);
        $codep = strip_tags($_POST['CodeP']);
        $ville = strip_tags($_POST['Ville']);
        $dep = strip_tags($_POST['Departement']);
        $region = strip_tags($_POST['Region']);
        $compl = strip_tags($_POST['Complement']);

        $sql = 'UPDATE `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise 
        SET `N_Entreprise`=:nom, `Siret`=:siret, `Desc_E`=:descrip, `Nb_Etudiant`=:nbEtudiant, `Note`=:note, `Numero`=:numero, `N_Rue`=:rue, `CodeP`=:codep, 
        `Ville`=:ville, `Departement`=:dep, `Region`=:region, `Complement`=:compl WHERE entreprise.Id_Entreprise= :id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':siret', $siret, PDO::PARAM_INT);
        $query->bindValue(':descrip', $descrip, PDO::PARAM_STR);
        $query->bindValue(':nbEtudiant', $nbEtudiant, PDO::PARAM_STR);
        $query->bindValue(':note', $note, PDO::PARAM_STR);
        $query->bindValue(':numero', $numero, PDO::PARAM_INT);
        $query->bindValue(':rue', $rue, PDO::PARAM_STR);
        $query->bindValue(':codep', $codep, PDO::PARAM_STR);
        $query->bindValue(':ville', $ville, PDO::PARAM_STR);
        $query->bindValue(':dep', $dep, PDO::PARAM_STR);
        $query->bindValue(':region', $region, PDO::PARAM_STR);
        $query->bindValue(':compl', $compl, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Entreprise modifiée";
        require_once('close.php');

        header('Location: http://localhost/Code/accueil/nav_admin/entreprises_admin.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Entreprise']) && !empty($_GET['Id_Entreprise'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Entreprise']);

    $sql = 'SELECT * FROM `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise  WHERE entreprise.Id_Entreprise = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $entreprise = $query->fetch();

    // On vérifie si le produit existe
    if(!$entreprise){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: http://localhost/Code/accueil/nav_admin/entreprises_admin.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: http://localhost/Code/accueil/nav_admin/entreprises_admin.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une entreprise</title>

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
                        <input type="text" id="N_Entreprise" name="N_Entreprise" class="form-control" value="<?= $entreprise['N_Entreprise']?>">
                    </div>
                    <div class="form-group">
                        <label for="Siret">Siret</label>
                        <input type="text" id="Siret" name="Siret" class="form-control" value="<?= $entreprise['Siret']?>">
                    </div>
                    <div class="form-group">
                        <label for="Desc_E">Description</label>
                        <input type="text" id="Desc_E" name="Desc_E" class="form-control" value="<?= $entreprise['Desc_E']?>">
                    </div>
                    <div class="form-group">
                        <label for="Nb_Etudiant">Nombre d'étudiant en stage</label>
                        <input type="text" id="Nb_Etudiant" name="Nb_Etudiant" class="form-control" value="<?= $entreprise['Nb_Etudiant']?>">
                    </div>
                    <div class="form-group">
                        <label for="Note">Note du pilote</label>
                        <input type="text" id="Note" name="Note" class="form-control" value="<?= $entreprise['Note']?>">
                    </div>
                    <h1>Adresse de l'entreprise</h1>
                    <div class="form-group">
                        <label for="Numero">Numéro</label>
                        <input type="text" id="Numero" name="Numero" class="form-control" value="<?= $entreprise['Numero']?>">
                    </div>
                    <div class="form-group">
                        <label for="N_Rue">Rue</label>
                        <input type="text" id="N_Rue" name="N_Rue" class="form-control" value="<?= $entreprise['N_Rue']?>">
                    </div>
                    <div class="form-group">
                        <label for="CodeP">Code Postal</label>
                        <input type="text" id="CodeP" name="CodeP" class="form-control" value="<?= $entreprise['CodeP']?>">
                    </div>
                    <div class="form-group">
                        <label for="Ville">Ville</label>
                        <input type="text" id="Ville" name="Ville" class="form-control" value="<?= $entreprise['Ville']?>">
                    </div>
                    <div class="form-group">
                        <label for="Departement">Département</label>
                        <input type="text" id="Departement" name="Departement" class="form-control" value="<?= $entreprise['Departement']?>">
                    </div>
                    <div class="form-group">
                        <label for="Region">Région</label>
                        <input type="text" id="Region" name="Region" class="form-control" value="<?= $entreprise['Region']?>">
                    </div>
                    <div class="form-group">
                        <label for="Complement">Complément</label>
                        <input type="text" id="Complement" name="Complement" class="form-control" value="<?= $entreprise['Complement']?>">
                    </div>
                    <input type="hidden" value="<?= $entreprise['Id_Entreprise']?>" name="Id_Entreprise">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
