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
            header('location: accueil/nav_admin/accueil_admin.php');
            exit;
        } elseif($row['Pilote'] == 1) {
            header('location: accueil/nav_pilote/accueil_pilote.php');
            exit;
        } elseif($row['Login'] == $uname && $row['Mdp'] == $pass) {
            header('location: accueil/nav_etudiant/accueil_etudiant.php');
            exit;
        } else {
            $error = "Login et/ou mot de passe incorrect";
        }
    } else {
        $error = "Login et/ou mot de passe incorrect";
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Authentification </title>
    </head>
    <body>
        <div class="container">
            <div class="image">
                <img src="http://localhost/B4/projet/L3/code/image/co.png" title= "bienvenue" >
            </div>
            <div class="logo">
                <img src="http://localhost/B4/projet/L3/code/image/logo.png" title="logo">
            </div>
            <div class="login-box">
                <h2>S'authentifier</h2>
                <form method="post">
                    <div class="user-box">
                        <input type="text" name="uname" required="">
                        <label>Identifiant</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="pass" required="">
                        <label>Mot de passe</label>
                    </div>
                    <a >
                        <input class="button" type="submit" name="submit" value="Connexion">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <a class="btnreset">
                        <input class="button" type="reset" value="Effacer" >
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
                        <a href="http://localhost/B4/Projet/L3/code/footer/actualites.php">Actualités</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/footer/a_propos.php">À Propos</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/footer/support.php">Support</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/footer/mentions_legales.php">Mentions Légales</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/footer/cgu.php">CGU</a> 
                    </li>
                </ul>
            </footer>
        </div>
    </body>
    
</html>








<?php
    /* Vérifier si Gandalf est dans la BDD 
    $req_str = "SELECT * FROM utilisateurs WHERE pseudo = 'Gandalf';";
    $stmt = $conn->query($req_str);
    if(!$stmt){echo "erreur de requête : $req_str\n";die;}
    if($stmt->fetch()){echo "Utilisateur Gandalf présent.\n"; $stmt->closeCursor();}
    else{echo "Utilisateur Gandalf introuvable";} */
?>
