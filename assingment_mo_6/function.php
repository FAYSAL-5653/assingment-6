<?php

if(isset($_POST["sub_btn"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $fileName = $_FILES['profile_pic']['name'];
    $tmpTmpn_ame = $_FILES['profile_pic']['tmp_name'];
    $fileType = $_FILES['profile_pic']['type'];
    if (empty($name) || empty($email) || empty($password)) {
        die("Error: All fields are required.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    } 
    ;
    if (empty($fileName)) {
        die("Error: Profile picture is required.");  
    }
    elseif($fileType !== 'image/jpeg' && $fileType!== 'image/png' && $fileType !== 'image/jpg') {
        die("Error: Invalid file format. Only JPEG, PNG, and JPG allowed.");
    }
    else {
        $upload_dir = 'uploads/';
        $creatFilename = uniqid() . '_' . date('Y-m-d_H-i-s') . '_' . $fileName;
        $upload_path = $upload_dir . $creatFilename;
        move_uploaded_file($tmpTmpn_ame,$upload_path);
    }
    $data = array($name, $email, $creatFilename);
    $file = fopen('users.csv', 'a');
    if (!$file) {
        die('Error opening file.');
    }
    if (!fputcsv($file, $data)) {
        die('Error writing to file.');
    }
    fclose($file);
    session_start();
    setcookie('username', $name);
    header('Location:display.php');
    exit();
}

?> 