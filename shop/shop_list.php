<?php
    session_start();
    session_regenerate_id(true);
    // データベースへ接続
    require_once('../config/dbconnect.php');
    // ファンクション呼び出し(エスケープ関数)
    require_once('../config/functions.php');

    // 商品の一覧をMysqlから取り出す
    $sql = "select * from mst_product";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_SESSION['cart'])==true){
        $cart = $_SESSION['cart'];    
    }
    if(empty($_SESSION["cart"])){
        unset($_SESSION["cart"]);
    }
    foreach($cart as $key => $value){
        $sql = "select code, name, price, image from mst_product where code=?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            $value['pro_code']
        ]);
        $master = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart[$key]['name'] = $master['name'];
        $cart[$key]['price'] = $master['price'];
        $cart[$key]['image'] = $master['image'];
    }

    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>product list</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
        .sidebar{
            border-left: 1px solid gray;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
<div class="container ml-6 pl-1">
    <div class="row">
        <div class="col-9 pr-5">
        <h3 class="my-3">商品一覧</h3>
            <!-- 商品の情報をそれぞれ取り出す -->
            <div class="row">
                <?php foreach($products as $product): ?>
                    <div class="col-3">
                        <a href="shop_display.php?procode=<?php echo $product['code']?>">
                        <img src="../product/fruits_image/<?php echo es($product['image']); ?>" style="width:200px" class="img-thumbnail border">
                        <p><?php echo $product['name']; ?>----<?php echo $product['price']?>円</p></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- 商品の取り出しここまで -->
        </div>
        
        <div class="col-3 pl-3 sidebar">
                <a href="./shop_cart/shop_cartlook.php" class="btn btn-success">カート中身を見る</a>
            <hr>
            <?php foreach($cart as $product): ?>
                    <h5>商品名：<?php echo es($product["name"]); ?></h5>
                        <img src="../product/fruits_image/<?php echo es($product['image']); ?>" style="width:100px" class="border">
                    <p>値段：<?php echo $product["price"]; ?>　円</p>
                    <label>個数：</label>
                    <form action="./shop_cart/num_change.php" method="post">
                        <select name="num">
                            <?php num_change($product["num"]); ?>
                        </select>
                        <input type="hidden" name="pro_code" value='<?php echo $product["pro_code"]; ?>'>
                        <input type="submit" value="数量変更">
                    </form>
                    <form action="shop_delete.php" method="post">
                        <input name="delete" type="checkbox">
                        <input type="hidden" name="pro_code" value='<?php echo $product["pro_code"]; ?>'>
                        <input class="my-3" type="submit" value="カートから削除">
                    </form>
                    <hr>
            <?php endforeach; ?>
            <?php if(isset($_SESSION['cart'])):?>
                <a class="btn btn-danger float-left" href="./shop_cart/clear_cart.php">カートクリア</a>
                <a class="btn btn-primary float-right" href="./shop_form/shop_form.php">購入手続き</a>
            <?php else: ?>
                <p>カートに商品は入っていません</p>
            <?php endif;?>
                </div>
        </div>
        </div>
    </div>
</div>
</body>
</html>