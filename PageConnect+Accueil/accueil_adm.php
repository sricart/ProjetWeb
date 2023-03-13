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
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Accueil Form </title>
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
                echo"{$row['Id_Etudiant']} - {$row['N_Etudiant']} - {$row['P_Etudiant']} - {$row['Cv']} - {$row['Lettre_Motivation']} 
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



    </body>
</html>
