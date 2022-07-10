<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    //データ受け取り
    $name = isset($_POST['name'])? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
    $price = isset($_POST['price'])? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
    $count = isset($_POST['count'])? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';

    session_start();

    //もし、sessionにproductsがあったら
    if(isset($_SESSION['products'])){  
        //$_SESSION['products']を$productsという変数にいれる
        $products = $_SESSION['products']; 
        //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
        foreach($products as $key => $product){  
            //もし、キーとPOSTで受け取った商品名が一致したら、
            if($key == $name){ 
                //既に商品がカートに入っているので、個数を足し算する     
                $count = (int)$count + (int)$product['count'];
            }
        }
    }  

    //配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
    if($name!=''&&$count!=''&&$price!=''){
        $_SESSION['products'][$name]=[
            'count' => $count,
            'price' => $price
        ];
    }
    $products = isset($_SESSION['products'])? $_SESSION['products']:[];
 ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Hotdog</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="cart.css"/>
    <link rel="stylesheet" href="responsive.css">
    <!--<script src="battle.js"></script>-->
    </head>

    <body>
        <header>
            <div class="container">
                <div class="area_name_header">
                    <h1><p class="shop_name">　shopname</p></h1>
                    <nav class="nav_header">
                        <ul class="list_nav_header">
                            <li><a  href="index.html"><br>ホーム</a></li>
                            <li><a  class="header_menu" href="all.php"><br>メニュー<span>▼</span></a>
                                <ul>
                                    <li><a href="all.php">ALL</a></li>
                                    <li><a href="food.php">Food</a></li>
                                    <li><a href="drink.php">Drink</a></li>
                                </ul>
                            </li>
                            <li><a  href="inquiry.html"><br>お問い合わせ</a></li>
                        </ul>
                        <a class="image_cart" href="cart.php"><img src="image/カート.png" width="65" height="65"></a>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <div class="confirm_form">
                <div class="container">
                    <div class="conf">
                        <p><?php echo $name; ?>をカートに入れました。</p>
                        <p>
                            現在<?php echo $name; ?>は<?php echo $count; ?>個カートに入っています。
                        </p>
                        <button type="button" class="btn btn-blue" onclick="location.href='cart.php'">購入手続きへ</button>
                        <button type="button" class="btn btn-gray" onclick="location.href='all.php'">お買い物を続ける</button>
                    </div>
                </div>
            </div>
        </main>