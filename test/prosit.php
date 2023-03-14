<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $bdd = 'projet';

    $login = $_POST['login'];
    $password = $_POST['password'];
    $amdin = $_POST['admin'];
    $pilote = $_POST['pilote'];
            
    //On essaie de se connecter
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$bdd", $username, $password);
        //On définit le mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if (!empty($_POST)) { 
            if (isset($_POST['afficher'])) { 
                /* Déclarer des variables contenu dans un forms HTML */
                
                if(strlen($login)>0){
                    $sql =  "SELECT *
                    FROM `Authentifiant` 
                    WHERE login = '" . $login . "';";
                }
                else{
                    $sql =  "SELECT * 
                    FROM `authentifiant`;";
                    } 
                foreach  ($conn->query($sql) as $row) {
                    echo $row['login'] . "\t";
                    echo $row['password'] . "\t";
                    echo $row['admin'] . "\t";
                    echo $row['pilote'] . "<br>";
                }
            } 
            elseif (isset($_POST['supprimer'])) { 
                if(strlen($login)>0){
                    $sql = "DELETE FROM `authentifiant`
                    WHERE login = '" . $login . "';";
                    $conn->query($sql);
                    echo "Pilote supprimer.";
                }  
                else{
                    echo "Veuillez inscrire un pilote.";
                }
            }
            /*
            elseif (isset($_POST['creer'])) { 
                if(strlen($login)==0 || strlen($password)==0){
                    echo "Veuillez remplir les informations";
                }
                else{
                    $REQ = "SELECT MAX(login) FROM authentifiant;";
                    if($conn->query($REQ)){
                        foreach  ($conn->query($REQ) as $row) {
                            $No = $row['MAX(login)'] + 1;
                        }
                        $REQ = "SELECT * FROM typevoiture WHERE NomTV = '" . $horse . "';";
                        if($conn->query($REQ)){
                            foreach  ($conn->query($REQ) as $row) {
                                $var = $row['NoTV'];
                            }
                            if($conn->query($REQ)){
                                $REQ = "INSERT INTO pilote (NoPil ,NomPil, NatPil, NoTV) VALUES ('" . $No . "' ,'" . $username ."' ,'" . $natio . "' ,'" . $var . "' );";
                                $conn->query($REQ);
                                echo "Pilote ajouté.";
                            }}}
                    else{echo "Erreur de requête.";}
                }}
            elseif (isset($_POST['update'])) { 
                if(strlen($natio) > 0){
                    $REQ = "UPDATE pilote SET NatPil = '" . $natio . "' WHERE NomPil = '" . $username . "';";
                    $conn->query($REQ);
                    echo "Pilote modifier : Nationalité = " . $natio . " pour " . $username;
                }
                if(strlen($horse) > 0){
                    $REQ = "SELECT NoTV FROM typevoiture WHERE NomTV = '" . $horse . "';";
                    if($conn->query($REQ)){
                        foreach  ($conn->query($REQ) as $row) {
                            $var = $row['NoTV'];
                        }
                        $REQ = "UPDATE pilote SET NoTV = '" . $var . "' WHERE NomPil = '" . $username . "';";
                        $conn->query($REQ);
                        echo "Pilote modifier : Ecurie = '" . $horse . "' pour '" . $username . "' avec un NoTV = '" . $var ."';";
                    }}}*/}}      
    /*On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
    catch(PDOException $e){echo "Erreur : " . $e->getMessage();}
?>

<html>
    <head>
        <meta charset="utf-8">  
         <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
        <!-- zone de connexion -->
            <form method="post">
                <h1>Authentifiant</h1>
                <label><b></b></label>
                <input type="text" placeholder="Entrer le login" name="login">
                <input type="text" placeholder="Entrer le mot de passe" name="mdp">
                <input type="text" placeholder="Admin ?" name="admin">
                <input type="text" placeholder="Pilote ?" name="pilote">
                <input type="submit" name="afficher" id='submit' value='AFFICHER'>
                <input type="submit" name="supprimer" id='submit' value='SUPPRIMER'>
                <input type="submit" name="creer" id='submit' value='CREER'>
                <input type="submit" name="update" id='submit' value='MODIFIER'>
            </form>
        </div>
    </body>
</html>

