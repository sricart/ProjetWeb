<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styl.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Etudiant </title>
        <script>
            function afficherInfo() {
                var infos = document.getElementById("infos");
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
            <div class="logo">LOGO</div>
            <nav class="nav-bar">
                <ul>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/accueil_pilote.php">Accueil</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/etudiants_pilote.php">Etudiant</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/entreprises&offres_pilote.php">Entreprises et Offres</a> 
                    </li>
                    <li>
                        <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/compte_pilote.php">Votre compte</a> 
                    </li>
                </ul>
            </nav>
        </header>

        Bienvenue sur la page pilote
        <br>
        <input type="button" onclick="afficherInfo()" value="AFFICHER">
        <br>
        <div id="infos" style="display:none">
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
                - {$row['Photo']} - {$row['Id_Promotion']}  - {$row['Id_Pilote']} - {$row['Id_Auth']} <br> ;";
            }
            ?>
        </div>
       
        <footer>
            <ul>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/footer/actualites.php">Actualités</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/footer/a_propos.php">À Propos</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/footer/support.php">Support</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/footer/mentions_legales.php">Mentions Légales</a> 
                </li>
                <li>
                    <a href="http://localhost/B4/Projet/L3/code/accueil/nav_pilote/footer/cgu.php">CGU</a> 
                </li>
            </ul>
        </footer>
    </body>
</html>