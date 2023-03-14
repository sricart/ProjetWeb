<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Page test upload</title> 
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="uploaded_file"> <br>
            <input type="submit" name="submit"> <br>
    </body>
</html>

<?php

if(isset($_POST['submit'])){
    $maxSize=50000;
    if($_FILES['uploaded_file'] > 0){
        echo "une erreur est survenue lors du transfert";
        die;
    }

    $fileSize=$_FILES['uploaded_file'];
    echo $fileSize;

}

?>