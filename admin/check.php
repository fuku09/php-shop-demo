<?php

    $email = isset($_POST['email'])? htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8') : '';
    $password = isset($_POST['password'])? htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8'): '';

    if ($email == '') {
        header("Location:./index.html");
        exit;
    }
    if ($password == '') {
        header("Location:./index.html");
        exit;
    }

    if ($email=='admin@admin.com'&&$password=='01') {
        session_start();
        $_SESSION['admin_login'] = true;
        //ログイン許可
        header("Location:./orders.php");
    } else {
        //間違っているのでログイン不可
        header("Location:./index.html");
        exit;
    }
?>