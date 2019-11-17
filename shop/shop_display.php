<?php
    session_start();
    session_regenerate_id(true);
    // データベースへ接続    
    require_once('../config/dbconnect.php');
    // ファンクション呼び出し(エスケープ関数)
    require_once('../config/functions.php');

    // 商品コードを取得
    $pro_code = $_GET['procode'];

    // 商品情報をデータベースから取り出す
    $sql = "select name, price, image from mst_product where code=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $pro_code
    ));
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>商品詳細</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
            <!-- 商品詳細表示 -->
                <h3>商品詳細</h3>
                <img src="../product/fruits_image/<?php echo es($product['image']); ?>" style="width:300px">
                <p>商品名：<?php echo es($product['name']); ?></p>
                <p>価格(税込)：<?php echo es($product['price']); ?>円</p>
                
                <!-- 商品購入ならshop_cartin.phpへ移動し、カートへ入れる処理を行う -->
                <a href="./shop_cart/shop_cartin.php?procode=<?php echo $pro_code; ?>">カートに入れる</a>
            <!-- 詳細表示ここまで -->
            </div>
        </div>
            <a href="shop_list.php">戻る</a>
    </div>
</body>
</html>