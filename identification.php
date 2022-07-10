<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    session_start();

    $identification = isset($_SESSION['identification'])? $_SESSION['identification']:[];

    //DB接続
    try {
        $dbh = new PDO("sqlite:../corporate.db"); 
        $dbh->query('SET NAMES utf8;');
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }

    $order_id = isset($_GET['id'])? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8'):'';//$identification['order_id'];

    $st1 = $dbh->prepare("SELECT * FROM order_products WHERE order_id=:order_id"); 
    $st1->bindParam(':order_id',$order_id);
    $st1->execute();
    $order_products = $st1->fetchAll(PDO::FETCH_ASSOC);
    
 ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Identification</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="cart.css"/>
    <link rel="stylesheet" href="responsive2.css">
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
                            <li><a  class="header_menu" href=""><br>メニュー<span>▼</span></a>
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
                <!--<div class="clearlist"></div> -->
            </div>
        </header>

        <main>
            <div class="last_wrapper">
                <div class="container">
                    <div class="wrapper_title">
                        <h3>ご購入者情報</h3>
                    </div>
                    <div class="pay-form">
                        <div class="form-group">
                            <p class="form-title">お名前</p>
                            <p><?php echo $identification['name']; ?></p>
                        </div>
                        <div class="form-group">
                            <p class="form-title">受け取り時刻</p>
                            <p><?php echo $identification['time']; ?></p>
                        </div>
                        <div class="form-group">
                            <p class="form-title">注文情報</p>
                            <table class="products_table">
                                <thead>
                                    <tr>
                                        <th>商品名</th>
                                        <th>個数</th>
                                        <th>金額</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($order_products as $order_product): ?>
                                        <tr>
                                            <td><?php echo $order_product['product_name']; ?></td>
                                            <td><?php echo $order_product['num']; ?></td>
                                            <td><?php echo $order_product['price']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <p class="form-title">合計金額</p>
                            <p><?php echo $identification['total']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>

</html>