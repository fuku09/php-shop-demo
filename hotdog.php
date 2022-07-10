<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>Hotdog</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="goods.css"/>
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
            <div class="container">
                <div class="goods_area">
                    <section class="area_goods_image">
                        <img class="goods" src="image/hotdog.jpeg">
                    </section>

                    <section class="area_goods_description">
                        <p class="description">
                            ホットドッグ{説明~~~}
                        </p>

                        <h5>ホットドッグ</h5>
                        <p>¥350</p>

                        <p>
                            <br>個数
                        </p>

                        <form action="confirm.php" method="POST" class="item-form">
                            <input type="hidden" name="name" value="ホットドッグ">
                            <input type="hidden" name="price" value="350">
                            <input type="text" value="1" name="count">

                            <button type="submit">カートに入れる</button>
                        </form> 

                    </section>
                </div>
            </div>

        </main>
    </body>
    <footer>
        <p>©️ 2021</p>
    </footer>
    
    <script language="Javascript">
        function Click_Sub() {
            if (document.all.div1.style.display == "none") {
                document.all.div1.style.display = "block"
            } else {
                document.all.div1.style.display = "none"
            }
        }
    </script>

</html>