<?php
// Initialisation des variables de connexion au serveur MySQL
$serveur = "localhost";
$username = "root";
$password = "";
$bdd = "projet";

// Initialisation des variables de vérification 
$connect = false;
$log = false;
$mdp = false;
$admin = 0;
$pilote = 0;
$admincon = false;
$pilotecon = false;
$error = "";
$success = "";

// Test de connexion à la BDD
try {
    $connexion = mysqli_connect($serveur, $username, $password, $bdd);
    //echo 'Connexion réussie à la base de données' . "<br>";
} catch(PDOException $e) {
    echo 'Erreur lors de la connexion à la base de données';
    die;
}

// Vérification de la bonne entrée du login et du mot de passe
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
    <title> Login Form </title>
</head>
<body>
    <div class="container">
        <div class="image">
            <img src="http://localhost/B4/Projet/L3/code/image/Illustration_pageco.png" title= "bienvenue" >
        </div>
        <form method="post">
            <div class="form-input">
                <i class="fa fa-user fa-2x cust" aria-hidden="true"></i>
                <input type="text" name="uname" value="" placeholder="Enter Username" required><br /> <br>
                <i class="fa fa-lock fa-2x cust" aria-hidden="true"> </i>
                <input type="password" name="pass" value="" placeholder="Enter Password" required><br />
                <a href="mdp_oublie.php"> Mot de passe oublié ? </a> <br><br>
                <input type="submit" name="submit" value="Login">
                <input type="reset" name="reset" value="Reset">
            </div>
        </form>
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
/*
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
    try{
        $connexion =  mysqli_connect("$serveur", "$username", "$password", "$bdd");
        echo'connexion réussi à la bdd réussie' . "<br>";
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
        $sql=mysqli_query($connexion,"SELECT * FROM authentifiant WHERE Login='".$uname."' AND Mdp='".$pass."' ")   ;
        $row = mysqli_fetch_assoc($sql);

    }

    catch(PDExeption $e){
        echo 'erreur';
        die;
    }

//vérification entré bon login et mdp 

//action à réaliser
    if(isset($_POST['submit'])){
            if($row ['Admin'] == 1)
            {
                header('location: accueil/nav_admin/accueil_admin.php');
                exit;
            }
            elseif($row ['Pilote'] == 1){
                header('location: accueil/nav_pilote/accueil_pilote.php');
                exit;
            }
            elseif($row ['Login'] == $uname && $row ['Mdp'] == $pass){
                header('location: accueil/nav_etudiant/accueil_etudiant.php');
                exit;
            }
            else{
                echo "<script> alert('Login et/ou mot de passe incorrect');</script>";
            }
            

        /*
            foreach($connexion->query($sql) as $row)


            if($log==true && $mdp==true && $admincon == false && $pilotecon == false){
                $connect=true;
                echo 'Vous êtes bien connecté en tant que ' . $uname;
                header('location: accueil_etu.php');
                exit;
                $success="Welcome";
                $error="";
            }
            elseif($log==true && $mdp==true && $admincon == true){
                    $connect=true;
                    echo 'Vous êtes bien connecté en tant que ' . $uname;
                    header('location: accueil_adm.php');
                    exit;
                    $success="Welcome";
                    $error="";
                }
            elseif($log==true && $mdp==true && $pilotecon == true){
                $connect=true;
                echo 'Vous êtes bien connecté en tant que ' . $uname;
                header('location: accueil_pil.php');
                exit;
                $success="Welcome";
                $error="";
            }
            /*
            else{
                $error="y'a un pb";
            }
        }
        
        else{
            $connect=false;
            $success="";
            $error="Error";
            //echo  "<script>alert('Login et/ou mot de passe incorrect');</script>";
        }
        */

?>

<?php
    /* Vérifier si Gandalf est dans la BDD 
    $req_str = "SELECT * FROM utilisateurs WHERE pseudo = 'Gandalf';";
    $stmt = $conn->query($req_str);
    if(!$stmt){echo "erreur de requête : $req_str\n";die;}
    if($stmt->fetch()){echo "Utilisateur Gandalf présent.\n"; $stmt->closeCursor();}
    else{echo "Utilisateur Gandalf introuvable";} */
?>
