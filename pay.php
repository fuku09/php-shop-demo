<?php
    //値の受け取り
    $time = isset($_POST['time'])? htmlspecialchars($_POST['time'],ENT_QUOTES,'utf-8'):'';
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Pay</title>
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
                    <form class="pay-form"  action="pay_card.php" method="POST">
                        <!--表示の必要がないのでhidden-->
                        <input type="hidden" name="time" value="<?php echo $time; ?>">
                        <div class="form-group">
                            <p class="form-title">お名前 *</p>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <p class="form-title">Email(任意) </p>
                            <input type="email" name="email">
                        </div>
                        <div class="form-group">
                            <p class="form-title">電話番号(ハイフンスペース無し) *</p>
                            <input type="tel" name="tel" type="[\d]*" minlength="10" maxlength="11" required>
                        </div>
                        <div class="abc">
                            <button type="submit" class="btn btn-blue">カード情報入力へ</button>
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