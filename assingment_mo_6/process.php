<?php

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ( empty( $name ) && empty( $email ) && empty( $password ) ) {
        die( "Error: All fields are required." );
    }
    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        die( "Error: Invalid email format." );
    }
    if ( isset( $_FILES["profile_pic"] ) ) {
            $filename = $_FILES['profile_pic']['name'];
            $tmp_path = $_FILES['profile_pic']['tmp_name'];
            $file_type = $_FILES['profile_pic']['type'];
    
            if ($file_type != 'image/jpeg' && $file_type != 'image/png') {
                die( "Error: Only JPG and PNG images are allowed." );

            }
           else {
            $upload_dir = 'uploads/';
            $upload_path = $upload_dir . $filename;
            move_uploaded_file($tmp_path, $upload_path);
        }



        
        $filename = uniqid() . '_' . date( 'Y-m-d_H-i-s' ) . '_' . $profile_pic['name'];

    if ( !move_uploaded_file( $upload_dir , $upload_path ) ) {
        die( 'Error uploading file.' );
    }

  
    $data = array( $name, $email, $filename );
    $file = fopen( 'users.csv', 'a' );

    if ( fputcsv( $file, $data ) === false ) {
        die( 'Error writing to file.' );
    }

    fclose( $file );

 
    session_start();
    setcookie( 'username', $name );

    header( 'Location: success.php' );
    exit();
}}
