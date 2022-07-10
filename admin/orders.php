<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    session_start();

    if($_SESSION['admin_login'] == false){
        header("Location:./index.html");
        exit;
    }

    //DB接続
    try {
        $dbh = new PDO("sqlite:../corporate.db"); 
        $dbh->query('SET NAMES utf8;');
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }
    //SELECT文でordersを取得して$ordersに配列で格納
    $st1 = $dbh->prepare("SELECT * FROM orders");
    $st2 = $dbh->prepare("SELECT * FROM orders ORDER BY pickup_at ASC");

    $st1->execute();
    $st2->execute();

    //1つ1つのレコードをリスト形式で出力
    $orders = $st1->fetchALL(PDO::FETCH_ASSOC);
    $orders2 = $st2->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Orders</title>

        
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
            <div class="wrapper_1">
                <div class="container">
                    <div class="orders_title">
                        <h3>受注管理</h3>
                        <!--<button type="button" class="button1" onclick="Click_Sub()">受け取り時間を昇順で並べる</button>  -->
                    </div>
                    <div class="list">
                        <table class="orders_table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>氏名</th>
                                    <th>電話番号</th>
                                    <th>合計金額</th>
                                    <th>注文日時</th>
                                    <th>受け取り時刻</th>
                                    <th>注文ステータス</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['name']; ?></td>
                                    <td><?php echo $order['tel']; ?></td>
                                    <td><?php echo $order['total']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                    <td><?php echo $order['pickup_at']; ?></td>
                                    <td>
                                        <?php if($order['order_status']==0): ?>
                                        　　　<button type="button" class="btn btn-red">受付中</button>
                                        <?php else: ?>
                                        　　　<button type="button" class="btn btn-blue">受け渡し完了</a></button>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-green" onclick="location.href='order_products.php?id=<?php echo $order['id']; ?>'">詳細</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="wrapper_2">
                <div class="container">
                    <div class="orders_title">
                        <h3>受注管理</h3>
                        <button type="button" class="button2" onclick="Click_Sub()">id順に戻す</button>
                    </div>
                    <div class="list">
                        <table class="orders_table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>氏名</th>
                                    <th>電話番号</th>
                                    <th>合計金額</th>
                                    <th>注文日時</th>
                                    <th>受け取り時刻</th>
                                    <th>注文ステータス</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders2 as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['name']; ?></td>
                                    <td><?php echo $order['tel']; ?></td>
                                    <td><?php echo $order['total']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                    <td><?php echo $order['pickup_at']; ?></td>
                                    <td>
                                        <?php if($order['order_status']==0): ?>
                                        　　　<button type="button" class="btn btn-red">受付中</button>
                                        <?php else: ?>
                                        　　　<button type="button" class="btn btn-blue">発送済</a></button>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-green" onclick="location.href='order_products.php?id=<?php echo $order['id']; ?>'">詳細</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </body>

    <script language="Javascript">
        function Click_Sub() {
            if (document.all.wrapper_1.style.display == "none") {
                document.all.wrapper_1.style.display = "block"
                document.all.wrapper_2.style.display = "none"
                document.all.button1.style.display = "none"
                document.all.button2.style.display = "block"
            } else {
                document.all.wrapper_1.style.display = "none"
                document.all.wrapper_2.style.display = "block"
                document.all.button2.style.display = "none"
                document.all.button1.style.display = "block"
            }
        }
    </script>

</html>