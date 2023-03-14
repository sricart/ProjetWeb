<?php

$user='root';
$pass='';
$bd='projet';
$bd=new mysqli('localhost', $user, $pass, $bd) or die ("unable to connect");

$sql="SELECT * FROM authentifiant";
$result=mysqli_query($bd,$sql) or die ("bad query");

while($row=mysqli_fetch_assoc($result))
{
    echo"{$row['Id_Auth']} {$row['Login']} {$row['Admin']} <br> ";
}

?>