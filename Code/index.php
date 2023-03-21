<?php
//Initialisation variable connection au serveur mysql
    $serveur = "localhost";
    $username = "root";
    $password = "";
    $bdd = "projet";

//Initialisation variable de vérification 
    $connect = false;
    $log = false;
    $mdp = false;
    $admin = 0;
    $pilote = 0;
    $admincon = false;
    $pilotecon = false;
    $error = "";
    $success = "";

//test de connection à la bdd
try {
    $connexion = mysqli_connect($serveur, $username, $password, $bdd);
    //  echo 'Connexion réussie à la base de données' . "<br>";
} catch(PDOException $e) {
    echo 'Erreur lors de la connexion à la base de données';
    die;
}
//vérification entré bon login et mdp 
if(isset($_POST['submit'])){
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM authentifiant WHERE Login = '".$uname."' AND Mdp = '".$pass."'";
    $result = mysqli_query($connexion, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if($row['Admin'] == 1) {
            header('location: http://localhost/code/accueil/nav_admin/accueil_admin.php');
            exit;
        } elseif($row['Pilote'] == 1) {
            header('location: http://localhost/code/accueil/nav_pilote/accueil_pilote.php');
            exit;
        } elseif($row['Login'] == $uname && $row['Mdp'] == $pass) {
            header('location: http://localhost/code/accueil/nav_etudiant/accueil_etudiant.php');
            exit;
        } else {
           
        }
    } else {
       
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <html lang="fr">
        <link rel="stylesheet" href="style.css">
        <title> Authentification </title>
    </head>
    <body>
        <div class="container">
            <div class="image">
                <img src="http://localhost/code/image/co.png" title= "bienvenue" >
            </div>
            <div class="login-box">
                <div class="logo">
                    <img src="http://localhost/code/image/logo.png" title="logo">
                </div>
                <br>
                <h2>S'authentifier</h2>
                <form method="post">
                    <div class="user-box">
                        <input type="text" name="uname" required="">
                        <label>Identifiant</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="pass" required="">
                        <label>Mot de passe</label>
                        <a class="mdp_oublie" href="mdp_oublie.php"> Mot de passe oublié ? </a>
                    </div>
                    <a >
                        <input class="button" type="submit" name="submit" value="Connexion" aria-labelledby="Login">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <a class="btnreset">
                        <input class="button" type="reset" value="Effacer" aria-labelledby="reset">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </form>
            </div>
        </div>
        <div class="footer">
            <footer>
                <ul>
                    <li>
                        <a href="http://localhost/code/footer/actualites.php">Actualités</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/footer/a_propos.php">À Propos</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/footer/support.php">Support</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/footer/mentions_legales.php">Mentions Légales</a> 
                    </li>
                    <li>
                        <a href="http://localhost/code/footer/cgu.php">CGU</a> 
                    </li>
                </ul>
            </footer>
        </div>
    </body>
    
</html>