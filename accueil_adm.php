<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Accueil Form </title>
    </head>
    <body>
        Bienvenue sur la page admin
        <br>
        affichage des infos :
    <br><br>
    
    <?php
    $user='root';
    $pass='';
    $bd='projet';
    $bd=new mysqli('localhost', $user, $pass, $bd) or die ("unable to connect");
    $sql="SELECT * FROM authentifiant";
    $result=mysqli_query($bd,$sql) or die ("bad query");
    while($row=mysqli_fetch_assoc($result))
    {
        echo"{$row['Id_Auth']} - {$row['Login']} {$row['Mdp']} {$row['Admin']} <br> ";
    }
    ?>
            

    </body>
</html>