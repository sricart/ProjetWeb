<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title> Accueil Form </title>
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
                echo"{$row['Id_Etudiant']} - {$row['N_Etudiant']} - {$row['P_Etudiant']} - {$row['Cv']} - {$row['Lettre_Motivation']} 
                - {$row['Photo']} - {$row['Id_Promotion']}  - {$row['Id_Pilote']} - {$row['Id_Auth']} <br> ;";
            }
            ?>
        </div>
    </body>
</html>