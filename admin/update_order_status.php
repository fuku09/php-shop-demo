<?php
    session_start();

    //ログインチェック
    if($_SESSION['admin_login'] == false){
        header("Location:./index.html");
        exit;
    }

    //id受け取り
    $id = isset($_GET['id'])? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8'):'';

    //idなかったらorders.phpにリダイレクト
    if($id==''){
        header('location:./orders.php');
    }

    //DB接続
    try {
        $dbh = new PDO("sqlite:../corporate.db");
        // 静的プレースホルダを指定
	    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // DBエラー発生時は例外を投げる設定
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }

    //update
    $stmt = $dbh->prepare("UPDATE orders SET order_status = 1 WHERE id=:id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();

    header('location:./orders.php');

?>