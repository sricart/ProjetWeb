<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Entreprise']) && !empty($_GET['Id_Entreprise']))
{
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Entreprise']);

    $sql = 'SELECT * FROM `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise WHERE entreprise.Id_Entreprise = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $etudiant = $query->fetch();

    // On vérifie si le produit existe
    if(!$etudiant)
    {
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
        die();
    }

    $sql = 'UPDATE `entreprise` INNER JOIN `adresse` ON entreprise.Id_Entreprise = adresse.Id_Entreprise 
    SET `N_Entreprise`=NULL, `Siret`=NULL, `Desc_E`=NULL, `Nb_Etudiant`=NULL, `Note`=NULL, `Numero`=NULL, `N_Rue`=NULL, `Ville`=NULL, `Departement`=NULL, 
    `Region`=NULL, `Complement`=NULL, `CodeP`=NULL WHERE entreprise.Id_Entreprise = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);
 
    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Entreprise supprimé";
    header('Location: index.php');
}

else
{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>