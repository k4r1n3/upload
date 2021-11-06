<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $uploadDir = '/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $newFile = uniqid('', true) . '.' . $uploadFile;
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
    $maxFileSize = 1048576;
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];

    if((!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Please select jpg, png, gif or webp extension !';
    } 

    if(file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name'] > $maxFileSize)){   
        $errors[] = 'Your picture is too large, please select one smaller than 1 Mo !';
    } 

    if(empty($firstname) || empty($lastname) || empty($age)){
        $errors[] = 'Please fill all labels !';
    }

    if(isset($_POST['delete'])){
        if (file_exists($newFile)){
            unlink($newFile);
        }
    }
    
    if(empty($errors)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newFile);
        echo 'Your picture has been uploaded !';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
<input type="text" name="firstname" id="firstname" placeholder="Your firstname">
<input type="text" name="lastname" id="lastname" placeholder="Your lastname">
<input type="number" name="age" id="age" placeholder="Your age">
<label for="imageUpload">Upload a profile image</label>
<input type="file" name="avatar" id="imageUpload">
<button name="send">Send</button>
<button name="delete">Delete</button>
</form>
    <div>
        <img src="<? $uploadDir . $newFile . $extension ?>">
    </div>
</body>
</html>