<?php
    // 値の受け取り
    $name = isset($_POST['name'])? htmlspecialchars($_POST['name'],ENT_QUOTES,'utf-8'):'';
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email'],ENT_QUOTES,'utf-8'):'';
    $tel = isset($_POST['tel'])? htmlspecialchars($_POST['tel'],ENT_QUOTES,'utf-8'):'';
    $time = isset($_POST['time'])? htmlspecialchars($_POST['time'],ENT_QUOTES,'utf-8'):'';
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Pay_Card</title>
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
        <div class="wrapper last_wrapper">
            <div class="container">
                <div class="wrapper_title">
                    <h3>決済カード情報</h3>
                    <span class="error"></span>
                </div>
                <form class="pay-form" action="pay_conf.php" method="POST">
                    <!--表示の必要がないのでhidden -->
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                    <input type="hidden" name="time" value="<?php echo $time; ?>">
                    <div class="form-group">
                        <p class="form-title">カード番号 *</p>
                        <input type="text" id="card-number" required>
                    </div>
                    <div class="form-group">
                        <p class="form-title">セキュリティーコード cvc*</p>
                        <input type="text" id="cvc" class="sm-form" required>
                    </div>
                    <div class="form-group">
                        <p class="form-title">カード有効期限 *</p>
                        <label>月</label>
                        <input type="text" id="exp_month" placeholder="12" class="sm-form" required>
                        <label>年</label>
                        <input type="text" id="exp_year" placeholder="2021" class="sm-form" required>
                    </div>
                    <div class="form-group">
                        <p class="form-title">カード名義 *</p>
                        <input type="text" id="card-name" placeholder="TARO KINDAI">
                    </div>
                    <button type="button" class="btn btn-blue confirm">確認する</button>
                </form>
            </div>
        </div>
        </main>
    </body>

    <footer>
        <p>©️ 2021</p>
    </footer>

    <script type="text/javascript" src="https://js.pay.jp/"></script>
    <!-- 公開鍵の設定 -->
    <script type="text/javascript">Payjp.setPublicKey('pk_test_6804fd15aff41db8c5fb2af7');</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(function(){
            $(".error").empty(); //最初はエラーは空

            // クレジットカード動作
            $(".confirm").click(function() {
            
                $(".error").empty(); //最初はエラーは空
                
                //それぞれの値を取得
                var number = $("#card-number").val();
                var cvc = $("#cvc").val();
                var exp_month = $("#exp_month").val();
                var exp_year = $("#exp_year").val();     

                //すべての値をcardに格納
                var card = {
                    number : number,
                    cvc : cvc,
                    exp_month : exp_month,
                    exp_year : exp_year
                };
            
                //トークン発行
                Payjp.createToken(card, function(s, response) {
                    if (response.error) {
                        // エラーの場合、エラー内容を表示
                        $(".error").append(response.error.message);
                        return false;
                    }else {
                        //OKの場合、response.idでトークンを取得
                        var token = response.id;
                        //取得したトークンをformに追加
                        $(".pay-form").append($('<input type="hidden" name="payjp_token" />').val(token));
                        //支払い実行ページに送信
                        $(".pay-form").submit();
                    }
                });
            });
        });
    </script>
</html>