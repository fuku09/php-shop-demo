<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    // 値の受け取り
    $name = isset($_POST['name'])? htmlspecialchars($_POST['name'],ENT_QUOTES,'utf-8'):'';
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email'],ENT_QUOTES,'utf-8'):'';
    $tel = isset($_POST['tel'])? htmlspecialchars($_POST['tel'],ENT_QUOTES,'utf-8'):'';
    $time = isset($_POST['time'])? htmlspecialchars($_POST['time'],ENT_QUOTES,'utf-8'):'';
    $payjp_token = isset($_POST['payjp_token'])? htmlspecialchars($_POST['payjp_token'],ENT_QUOTES,'utf-8'):'';
 ?>

<html lang="ja">
    <head>
    <title>Pay_Confirmation</title>
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
                        <h3>ご購入者情報</h3>
                    </div>
                    <form class="pay-form"  action="pay_end.php" method="POST">
                        <input type="hidden" name="payjp_token" value="<?php echo $payjp_token; ?>">
                        <div class="form-group">
                            <p class="form-title">お名前 *</p>
                            <p><?php echo $name; ?></p>
                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <p class="form-title">Email</p>
                            <p><?php echo $email; ?></p>
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <p class="form-title">電話番号 *</p>
                            <p><?php echo $tel; ?></p>
                            <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                        </div>

                        <div class="form-group">
                            <p class="form-title">受け取り時刻 *</p>
                            <p><?php echo $time; ?></p>
                            <input type="hidden" name="time" value="<?php echo $time; ?>">
                        </div>

                        <div class="blue_btn">
                            <p>この内容で送信してよろしいですか？</p>
                            <button type="submit" class="btn btn-blue">購入する</button>
                            <button type="button" class="btn btn-gray" onclick="location.href='./pay.php'">修正する</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>

    <footer>
        <p>©️ 2021</p>
    </footer>
</html>