<?php
//Initialisation variable connection au serveur mysql
    $serveur = "localhost";
    $username = "root";
    $password = "";

//Initialisation variable de vérification 
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $connect = false;
    $log = false;
    $mdp = false;
    $error = "";
    $success = "";

//test de connection à la bdd
    try{
        $connexion = new PDO('mysql:host=localhost;dbname=wrk8', $username, $password);
        echo'connexion réussi à la bdd réussie' . "<br>";
        $sqlp="SELECT pseudo FROM utilisateurs";
        $sqla="SELECT motDePasse FROM utilisateurs";
    }

    catch(PDExeption $e){
        echo 'erreur' . $e->getMessage();
        die;
    }

//vérification entré bon login et mdp  
    foreach($connexion->query($sqlp) as $row){
        if($row ['pseudo'] == $uname){
            $log = true;

            foreach($connexion->query($sqla) as $row){
                if($row ['motDePasse'] == $pass){
                    $mdp = true;
                }
            }
        }
    }

//action à réaliser
    if(isset($_POST['submit'])){
        if($log==true && $mdp==true){
            $connect=true;
            echo 'Vous êtes bien connecté en tant que ' . $uname;
            header('location: acceuil.php');
            exit;
            $success="Welcome";
            $error="";
        }

    else{
        $connect=false;
        $success="";
        $error="Error";
        //echo  "<script>alert('Login et/ou mot de passe incorrect');</script>";
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
                <form method="post">
                <div class="form-input">
                    <p class="error"> <?php echo $error; ?></p> <p class="success"> <?php echo $success; ?> </p>
                    <i class="fa fa-user fa-2x cust" aria-hidden="true"></i>
                    <input type="text" name="uname" value="" placeholder="Enter Username" required><br /> <br>
                    <i class="fa fa-lock fa-2x cust" aria-hidden="true"> </i>
                    <input type="password" name="pass" value="" placeholder="Enter Password" required><br />
                    <a href="#"> Forget Password </a> <br><br>
                    <input type="submit" name="submit" value="Login">
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
