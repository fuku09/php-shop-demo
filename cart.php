<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    class select {
        public function time_count($start,$end) {
            try {
                $dbh = new PDO("sqlite:corporate.db");
                $dbh->query('SET NAMES utf8;');
                // 静的プレースホルダを指定
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
                // DBエラー発生時は例外を投げる設定
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "エラー!: " . $e->getMessage() . "<br/>";
            }
            $sql = "SELECT count(*) as count1 FROM orders WHERE pickup_at BETWEEN '$start' AND '$end'";
            $stmt = $dbh->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["count1"];
        }
    }

    //削除する対象の名前を取得
    $delete_name = isset($_POST['delete_name'])? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';

    session_start();

    //session_startの後に削除対象の名前に従ってカートから削除
    if($delete_name != '') unset($_SESSION['products'][$delete_name]);

    //合計の初期値は0
    $total = 0;
    //カートが空の場合は空の配列を渡す
    $products = isset($_SESSION['products'])? $_SESSION['products']:[];

    foreach($products as $name => $product){
        //各商品の小計を取得
        $subtotal = (int)$product['price']*(int)$product['count'];
        //各商品の小計を$totalに足す
        $total += $subtotal;
    }

    date_default_timezone_set('Asia/Tokyo');
    $now_date = date('Y-m-d');
    $now_hour = date('H');
    $now_minute = date('i');

    $obj = new select();

    $count12_1 = $obj->time_count('12:00','12:14');
    $count12_2 = $obj->time_count('12:15','12:29');
    $count12_3 = $obj->time_count('12:30','12:44');
    $count12_4 = $obj->time_count('12:45','12:59');

    $count13_1 = $obj->time_count('13:00','13:14');
    $count13_2 = $obj->time_count('13:15','13:29');
    $count13_3 = $obj->time_count('13:30','13:44');
    $count13_4 = $obj->time_count('13:45','13:59');

    //データーベースから切断する。
    unset($dbh);
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Cart</title>
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
            <section class="area_goods">
                <!--カートに入っている商品を並べる-->
                <div class="container">
                    <div class="cartlist">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>商品名</th>
                                    <th>価格</th>
                                    <th>個数</th>
                                    <th>小計</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $name => $product): ?>
                                    <tr>
                                        <td label="商品名："><?php echo $name; ?></td>
                                        <td label="価格：" class="text-right">¥<?php echo $product['price']; ?></td>
                                        <td label="個数：" class="text-right"><?php echo $product['count']; ?></td>
                                        <td label="小計：" class="text-right">¥<?php echo $product['price']*$product['count']; ?></td>
                                        <td>
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="delete_name" value="<?php echo $name; ?>">
                                                <button type="submit" class="btn btn-red">削除</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total">
                                    <th colspan="3">合計</th>
                                    <td colspan="2">¥<?php echo $total; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="area_time">
                <p>
                    受け取り時刻を選択してください
                </p>
                <p><?php echo $now_date; ?></p>

                <!--ページを読み込んだ際-->
                <script>
                    var now_hour = <?php echo $now_hour; ?>; //現在時間
                    var now_minute = <?php echo $now_minute; ?>; //現在分
                    var count12_1 = <?php echo $count12_1; ?>; //12:00~12:14のカウント
                    var count12_2 = <?php echo $count12_2; ?>;
                    var count12_3 = <?php echo $count12_3; ?>;
                    var count12_4 = <?php echo $count12_4; ?>;

                    var count13_1 = <?php echo $count13_1; ?>;
                    var count13_2 = <?php echo $count13_2; ?>;
                    var count13_3 = <?php echo $count13_3; ?>;
                    var count13_4 = <?php echo $count13_4; ?>;

                    var arrival_rate = 30; //到着率
                    var service_rate = 50; //サービス率
                    var ideal_crowd = 1.0;
                    //受け入れ人数の上限
                    var mo_num = (ideal_crowd * service_rate) -arrival_rate

                    //現在時刻を取得し,30分以上前でないと注文できないようにする (受け入れ人数の上限を超えても注文できないように)
                    window.onload = function(){
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count12_1 > mo_num/4){
                            document.all.t_12_00.style.display = "none"
                            document.all.t_12_05.style.display = "none"
                            document.all.t_12_10.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count12_2 > mo_num/4){
                            document.all.t_12_15.style.display = "none"
                            document.all.t_12_20.style.display = "none"
                            document.all.t_12_25.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count12_3 > mo_num/4){
                            document.all.t_12_30.style.display = "none"
                            document.all.t_12_35.style.display = "none"
                            document.all.t_12_40.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count12_4 > mo_num/4){
                            document.all.t_12_45.style.display = "none"
                            document.all.t_12_50.style.display = "none"
                            document.all.t_12_55.style.display = "none"
                        }

                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count13_1 > mo_num/4){
                            document.all.t_13_00.style.display = "none"
                            document.all.t_13_05.style.display = "none"
                            document.all.t_13_10.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count13_2 > mo_num/4){
                            document.all.t_13_15.style.display = "none"
                            document.all.t_13_20.style.display = "none"
                            document.all.t_13_25.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count13_3 > mo_num/4){
                            document.all.t_13_30.style.display = "none"
                            document.all.t_13_35.style.display = "none"
                            document.all.t_13_40.style.display = "none"
                        }
                        if(/*(now_hour == 11 && now_minute > 30) || (now_hour > 12) ||*/ count13_4 > mo_num/4){
                            document.all.t_13_45.style.display = "none"
                            document.all.t_13_50.style.display = "none"
                            document.all.t_13_55.style.display = "none"
                        }
                    }
                </script>

                <form class="area_time_form" action="pay.php" method="POST">
                    <select name="time">
                        <optgroup label="12:00">
                            <option id="t_12_00" value="12:00">12:00</option>
                            <option id="t_12_05" value="12:05">12:05</option>
                            <option id="t_12_10" value="12:10">12:10</option>

                            <option id="t_12_15" value="12:15">12:15</option>
                            <option id="t_12_20" value="12:20">12:20</option>
                            <option id="t_12_25" value="12:25">12:25</option>

                            <option id="t_12_30" value="12:30">12:30</option>
                            <option id="t_12_35" value="12:35">12:35</option>
                            <option id="t_12_40" value="12:40">12:40</option>

                            <option id="t_12_45" value="12:45">12:45</option>
                            <option id="t_12_50" value="12:50">12:50</option>
                            <option id="t_12_55" value="12:55">12:55</option>
                        </optgroup>
                        <optgroup label="13:00">
                            <option id="t_13_00" value="13:00">13:00</option>
                            <option id="t_13_05" value="13:05">13:05</option>
                            <option id="t_13_10" value="13:10">13:10</option>

                            <option id="t_13_15" value="13:15">13:15</option>
                            <option id="t_13_20" value="13:20">13:20</option>
                            <option id="t_13_25" value="13:25">13:25</option>

                            <option id="t_13_30" value="13:30">13:30</option>
                            <option id="t_13_35" value="13:35">13:35</option>
                            <option id="t_13_40" value="13:40">13:40</option>

                            <option id="t_13_45" value="13:45">13:45</option>
                            <option id="t_13_50" value="13:50">13:50</option>
                            <option id="t_13_55" value="13:55">13:55</option>
                        </optgroup>
                    </select>
                    <button type="submit" class="btn btn-blue"<?php if(empty($products)) echo 'disabled="disabled"'; ?>>購入手続きへ</button>
                </form>
                <button type="button" class="btn btn-gray" onclick="location.href='all.php'">お買い物を続ける</button>
            </section>

        </main>

    </body>
    <footer>
        <p>©️ 2021</p>
    </footer>
</html>