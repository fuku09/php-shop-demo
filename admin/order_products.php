<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    session_start();

    //ログインチェック
    if($_SESSION['admin_login'] == false){
        header("Location:./index.html");
        exit;
    }

    $id = isset($_GET['id'])? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8'):'';

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

    //orders
    $stmt1 = $dbh->prepare("SELECT * FROM orders WHERE id=:id");
    $stmt1->bindParam(':id',$id);
    $stmt1->execute();
    $orders = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    //order_products
    $stmt2 = $dbh->prepare("SELECT * FROM order_products WHERE order_id=:id");
    $stmt2->bindParam(':id',$id);
    $stmt2->execute();
    $order_products = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Order_Product</title>

        
        <!-- css -->
        <link rel="stylesheet" href="order.css">

    </head>

    <body>
        <header>
            <div class="container">
                <div class="area_name_header">
                    <h1>管理画面</h1>
                </div>

                <nav class="menu-right menu">
                    <a href="logout.php">ログアウト</a>
                </nav>
            </div>
        </header>

        <main>
            <div class="wrapper">
                <div class="container">
                    <div class="orders_title">
                        <h3>受注詳細</h3>
                    </div>
                    <div class="list">
                        <h4>購入者情報</h4>
                        <table class="products_table">
                            <tbody>
                                <tr>
                                    <th>氏名</th><td><?php echo $orders[0]['name']; ?></td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th><td><?php echo $orders[0]['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>電話番号</th><td><?php echo $orders[0]['tel']; ?></td>
                                </tr>
                                <tr>
                                    <th>合計金額</th><td><?php echo $orders[0]['total']; ?></td>
                                </tr>
                                <tr>
                                    <th>受注日時</th><td><?php echo $orders[0]['created_at']; ?></td>
                                </tr>
                                <tr>
                                    <th>受け取り時刻</th><td><?php echo $orders[0]['pickup_at']; ?></td>
                                </tr>
                                <tr>
                                    <th>注文状況</th>
                                    <td><?php if($orders[0]['order_status']==0): ?>
                                            <button type="button" class="btn btn-red">受付中</button>
                                            <button type="button" class="btn btn-blue2" onclick="location.href='update_order_status.php?id=<?php echo $id; ?>'">受け渡し完了にする</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-blue">受け渡し完了</button>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>商品詳細</h4>
                        <table class="products_table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>注文ID</th>
                                    <th>商品名</th>
                                    <th>個数</th>
                                    <th>金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order_products as $order_product): ?>
                                <tr>
                                    <td><?php echo $order_product['id']; ?></td>
                                    <td><?php echo $order_product['order_id']; ?></td>
                                    <td><?php echo $order_product['product_name']; ?></td>
                                    <td><?php echo $order_product['num']; ?></td>
                                    <td><?php echo $order_product['price']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <footer>
        <p>©️ 2021</p>
    </footer>
</html>