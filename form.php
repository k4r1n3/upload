<?php

if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
    $maxFileSize = 1000000;
    $errors = [];

    if((!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Please select jpg, png, gif or webp extension !';
    } 
    if(file_exists($_FILES['avatar']['tmp_name'])) {
        $errors[] = 'This name already exists !';
    } 
    if(file_exists($_FILES['avatar']['tmp_name'] > $maxFileSize)) {
        $errors[] = 'Your picture is too large, please select one smaller than 1 Mo !';
    } 
    
    if(empty($errors)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
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
</form>
</body>
</html>