<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Pilote']) && !empty($_GET['Id_Pilote']))
{
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Pilote']);

    $sql = 'SELECT * FROM `pilote` INNER JOIN `authentifiant` ON pilote.Id_Auth = authentifiant.Id_Auth WHERE `Id_Pilote` = :id;';

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
        header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
        die();
    }

    $sql = 'UPDATE `pilote` INNER JOIN `authentifiant` ON pilote.Id_Auth = authentifiant.Id_Auth SET `N_Pilote`=NULL, `P_Pilote`=NULL, `Login`=NULL, `Mdp`=NULL WHERE `Id_Pilote`= :id;';

    // On prépare la requête
    $query = $db->prepare($sql);
 
    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Pilote supprimé";
    header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
}

else
{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: http://localhost/Code/accueil/nav_admin/pilotes_admin.php');
}
?>