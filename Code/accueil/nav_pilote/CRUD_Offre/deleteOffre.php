<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['Id_Offre']) && !empty($_GET['Id_Offre']))
{
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['Id_Offre']);

    $sql = 'SELECT * FROM `offre` WHERE `Id_Offre` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $offre = $query->fetch();

    // On vérifie si le produit existe
    if(!$offre)
    {
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: http://localhost/code/accueil/nav_pilote/offres_pilote.php');
        die();
    }

    $sql = 'UPDATE `offre` SET `N_Offre`=NULL, `Statut_Offre`=NULL, `Desc_Offre`=NULL, `Duree`=NULL, `Remuneration`=NULL, 
    `Date_Pub`=NULL, `Anne2`=NULL, `Anne3`=NULL, `Anne4`=NULL, `Anne5`=NULL 
    WHERE `Id_Offre`= :id;';

    // On prépare la requête
    $query = $db->prepare($sql);
 
    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Etudiant supprimé";
    header('Location: http://localhost/code/accueil/nav_pilote/offres_pilote.php');
}

else
{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: http://localhost/code/accueil/nav_pilote/offres_pilote.php');
}
?>