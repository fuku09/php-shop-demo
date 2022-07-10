<!DOCTYPE html>
<html lang="ja">
    <head>
    <title>ALL Menu</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="all.css"/>
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
            <div class="container">
                <div class="menu_select">
                    <ul>
                        <li><a href="all.php">ALL</a></li>
                        <li><a href="food.php">Food</a></li>
                        <li><a href="drink.php">Drink</a></li>
                    </ul>
                </div>
            </div>
            <section class="menu">
                <div class="container">
                    <div class="menu_box">
                        <ul>
                            <li><a href="hotdog.php"><img class="menu_size" src="image/hotdog.jpeg"></a>
                                <div class="item_body">
                                    <h5>ホットドッグ</h5>
                                    <p>¥350</p>
                                </div>
                            </li>
                            <li><a href=""><img class="menu_size" src="image/chicken.jpeg"></a>                            
                                <div class="item_body">
                                    <h5>チキン</h5>
                                    <p>¥250</p>
                                </div></li>
                            <li><a href=""><img class="menu_size" src="image/furitto.jpeg"></a>
                                <div class="item_body">
                                    <h5>フリッツ</h5>
                                    <p>¥250</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="menu_box">
                        <ul>
                            <li><a href=""><img class="menu_size" src="image/ko-la.jpeg"></a>
                                <div class="item_body">
                                    <h5>コーラ</h5>
                                    <p>¥150</p>
                                </div>
                            </li>
                            <li><a href=""><img class="menu_size" src="image/ginger.jpeg"></a>
                                <div class="item_body">
                                    <h5>ジンジャーエール </h5>
                                    <p>¥150</p>
                                </div>
                            </li>
                            <li><a href=""><img class="menu_size" src="image/melon.jpeg"></a>
                                <div class="item_body">
                                    <h5>メロンソーダ</h5>
                                    <p>¥150</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clearlist"></div>
                </div>
            </section>
        </main>
    </body>

    <footer>
        <p>©️ 2021</p>
    </footer>
</html>