<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Etudiant']) && !empty($_GET['Id_Etudiant']))
{
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Etudiant']);

    $sql = 'SELECT * FROM `etudiant` INNER JOIN `authentifiant` ON etudiant.Id_Auth = authentifiant.Id_Auth WHERE `Id_Etudiant` = :id;';

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

    $sql = 'UPDATE `etudiant` INNER JOIN `authentifiant` ON etudiant.Id_Auth = authentifiant.Id_Auth SET `N_Etudiant`=NULL, `P_Etudiant`=NULL, `Cv`=NULL, `Lettre_Motivation`=NULL, `Photo`=NULL, `Login`=NULL, `Mdp`=NULL WHERE `Id_Etudiant`= :id;';

    // On prépare la requête
    $query = $db->prepare($sql);
 
    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Etudiant supprimé";
    header('Location: index.php');
}

else
{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>