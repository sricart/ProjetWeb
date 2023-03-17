<?php
$user='root';
$pass='';
$bd='projet';
$bd=new mysqli('localhost', $user, $pass, $bd) or die ("unable to connect");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/style.css">
        <title> Accueil </title>
        <script>
            function afficherInfoAut() {
                var infos = document.getElementById("infos");
                if (infos.style.display === "none") {
                    infos.style.display = "block";
                } else {
                    infos.style.display = "none";
                }
            }
            function afficherInfoEtu() {
                var infos = document.getElementById("infos_Etu");
                if (infos.style.display === "none") {
                    infos.style.display = "block";
                } else {
                    infos.style.display = "none";
                }
            }
            function afficherInfoPil() {
                var infos = document.getElementById("infos_Pil");
                if (infos.style.display === "none") {
                    infos.style.display = "block";
                } else {
                    infos.style.display = "none";
                }
            }

        </script>
    </head>
    <body>
    <header>
            <div class="logo"> <img src="http://localhost/B4/projet/L3/code/image/logo.png">
            </div>
            <div class="search-bar">
                <input type="search" class="search" placeholder="rechercher">
            </div>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <nav class="nav-bar">
                <ul>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/accueil_admin.php">Accueil</a> 
                    </li>
                    <li>
                        <a>Utilisateurs</a> 
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/etudiants_admin.php">Etudiants </a>
                                </li>
                                <li>
                                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/pilotes_admin.php">Pilotes </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a>Entreprises et Offres</a>
                        <div class="sous-menu">
                            <ul>
                                <li>
                                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/entreprises_admin.php" > Entreprises </a>
                                </li>
                                <li>
                                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/offres_admin.php" > Offres </a>
                                </li>
                            </ul>
                        </div>  
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/compte_admin.php">Votre compte</a> 
                    </li>
                </ul>
            </nav>
        </header>

        Afficher les informations sur les authentifiants
        <br>
        <input type="button" onclick="afficherInfoAut()" value="AFFICHER">
        <br>
        <div id="infos" style="display:none">
            <?php
            $sql="SELECT * FROM authentifiant";
            $result=mysqli_query($bd,$sql) or die ("bad query");
            while($row=mysqli_fetch_assoc($result))
            {
                echo"{$row['Id_Auth']} - {$row['Login']} - {$row['Mdp']} - {$row['Admin']} - {$row['Pilote']} <br> ";
            }
            ?>
        </div>

        Afficher les informations sur les étudiants
        <br>
        <input type="button" onclick="afficherInfoEtu()" value="AFFICHER">
        <br>
        <div id="infos_Etu" style="display:none">
            <?php
            $user='root';
            $pass='';
            $bd='projet';
            $bd=new mysqli('localhost', $user, $pass, $bd) or die ("unable to connect");
            $sql="SELECT * FROM etudiant";
            $result=mysqli_query($bd,$sql) or die ("bad query");
            while($row=mysqli_fetch_assoc($result))
            {
                echo"{$row['Id_Etudiant']} - {$row['N_Etudiant']} - {$row['P_Etudiant']} - {$row['Statut_Stage']} - {$row['Cv']} - {$row['Lettre_Motivation']} 
                - {$row['Photo']} - {$row['Id_Promotion']}  - {$row['Id_Pilote']} - {$row['Id_Auth']} <br> ";
            }
            ?>
        </div>

        Afficher les informations sur les pilotes
        <br>
        <input type="button" onclick="afficherInfoPil()" value="AFFICHER">
        <br>
        <div id="infos_Pil" style="display:none">
            <?php
            $user='root';
            $pass='';
            $bd='projet';
            $bd=new mysqli('localhost', $user, $pass, $bd) or die ("unable to connect");
            $sql="SELECT * FROM pilote";
            $result=mysqli_query($bd,$sql) or die ("bad query");
            while($row=mysqli_fetch_assoc($result))
            {
                echo"{$row['Id_Pilote']} - {$row['N_Pilote']} - {$row['P_Pilote']} - {$row['Id_Auth']} <br> ";
            }
            ?>
        </div>

        <footer>
            <ul>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_admin/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
        <script src="http://localhost/B4/Projet/L3/code/accueil/nav_admin/app.js"> </script>
    </body>
</html>
