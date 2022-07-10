<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    require_once './vendor/payjp/payjp-php/init.php';
    \Payjp\Payjp::setApiKey("sk_test_f9d64154659e56571f478ece"); //テストの秘密鍵

    // 値の受け取り
    $name = isset($_POST['name'])? htmlspecialchars($_POST['name'],ENT_QUOTES,'utf-8'):'';
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email'],ENT_QUOTES,'utf-8'):'';
    $tel = isset($_POST['tel'])? htmlspecialchars($_POST['tel'],ENT_QUOTES,'utf-8'):'';
    $time = isset($_POST['time'])? htmlspecialchars($_POST['time'],ENT_QUOTES,'utf-8'):'';
    $payjp_token = isset($_POST['payjp_token'])? htmlspecialchars($_POST['payjp_token'],ENT_QUOTES,'utf-8'):'';

    session_start();
    //productの情報をセッションから取得
    $products = isset($_SESSION['products'])? $_SESSION['products']:[];
    //トータルに初期値で0を与える
    $total = 0;
    //商品全てのトータルを計算
    foreach($products as $key => $product){
        $subtotal = (int)$product['price']*(int)$product['count'];
        $total += $subtotal;
    }

    $currency = 'jpy';

    $res = \Payjp\Charge::create(array(
        "card" => $payjp_token,
        "amount" => (int)$total,
        "currency" => "jpy"
    ));

    if($res['error']){
        $result = '決済処理に失敗しました。';
        $result_title = '決済失敗';
    }else{
        $result = 'ご購入ありがとうございます。';
        $result_title = 'Successful Purchase';
    }

    //DB接続
    try {
        $dbh = new PDO("sqlite:corporate.db");
        // 静的プレースホルダを指定
	    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // DBエラー発生時は例外を投げる設定
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }

    //ordersテーブル

    date_default_timezone_set('Asia/Tokyo');
    $now_date = date('Y-m-d H:i:s');

    $stmt1 = $dbh->prepare("INSERT INTO orders(name,email,tel,total,created_at,pickup_at) VALUES(:name,:email,:tel,:total,:now_date,:time)");
      
    $stmt1->bindParam(':name',$name);
    $stmt1->bindParam(':email',$email);
    $stmt1->bindParam(':tel',$tel);
    $stmt1->bindParam(':total',$total);
    $stmt1->bindParam(':now_date',$now_date);
    $stmt1->bindParam(':time',$time);
    $stmt1->execute();

    //ordersのid取得,最新でinsertされたidを取得
    $order_id = $dbh->lastInsertId();

    //order_productsテーブル
    foreach($products as $key => $product){
        $stmt2 = $dbh->prepare("INSERT INTO order_products(order_id,product_name,num,price) VALUES(:order_id,:product_name,:num,:price)");
        $stmt2->bindParam(':order_id',$order_id);
        $stmt2->bindParam(':product_name',$key);
        $stmt2->bindParam(':num',$product['count']);
        $stmt2->bindParam(':price',$product['price']);
        $stmt2->execute();
    }

    unset($_SESSION['products']);

    $_SESSION['identification']=array(
            'order_id' => $order_id,
            'name' => $name,
            'time' => $time,
            'total' => $total
    );
        

    //データーベースから切断する。
    unset($dbh);
    
 ?>

<html lang="ja">
    <head>
    <title><?php echo $result_title; ?></title>
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
                <!--<div class="clearlist"></div> -->
            </div>
        </header>

        <main>
            <div class="last_wrapper">
                <div class="container">
                    <div class="wrapper_title">
                    <h3><?php echo $result_title; ?></h3>
                    </div>
                    
                    <div class="end_form">
                        <h4><?php echo $result; ?>
                            <br><br>
                            ご来店お待ちしております。
                            <br><br>
                            ご来店の際は
                        </h4>
                        
                        <button type="button" class="btn btn-blue" onclick="location.href='index.html'">トップページへ</button>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <footer>
        <p>©️ 2021</p>
    </footer>
</html>