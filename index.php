<?php
//Initialisation variable connection au serveur mysql
    $serveur = "localhost";
    $username = "root";
    $password = "";
    $bdd = "projet";

//Initialisation variable de vérification 
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
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
        $sql=mysqli_query($connexion,"SELECT * FROM authentifiant WHERE Login='".$uname."' AND Mdp='".$pass."' ")   ;
        $row = mysqli_fetch_assoc($sql);

    }

    catch(PDExeption $e){
        echo 'erreur' . $e->getMessage();
        die;
    }

//vérification entré bon login et mdp 

    

//action à réaliser
    if(isset($_POST['submit'])){
            if($row ['Admin'] == 1)
            {
                header('location: accueil_adm.php');
                exit;
            }
            elseif($row ['Pilote'] == 1){
                header('location: accueil_pil.php');
                exit;
            }
            elseif($row ['Login'] == $uname && $row ['Mdp'] == $pass){
                header('location: accueil_etu.php');
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
            }*/
        }
        
        /*else{
            $connect=false;
            $success="";
            $error="Error";
            //echo  "<script>alert('Login et/ou mot de passe incorrect');</script>";
        }
        */
    



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
                <form method="post">
                <div class="form-input">
                    <p class="error"> <?php echo $error; ?></p> <p class="success"> <?php echo $success; ?> </p>
                    <i class="fa fa-user fa-2x cust" aria-hidden="true"></i>
                    <input type="text" name="uname" value="" placeholder="Enter Username" required><br /> <br>
                    <i class="fa fa-lock fa-2x cust" aria-hidden="true"> </i>
                    <input type="password" name="pass" value="" placeholder="Enter Password" required><br />
                    <a href="#"> Mot de passe oublié ? </a> <br><br>
                    <input type="submit" name="submit" value="Login">
                    <input type="reset" name="reset" value="Reset">
                </div>
            </form>
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
