<?php
session_start();
session_regenerate_id(true);

require_once('../../config/dbconnect.php');
require_once('../../config/functions.php');


// カートに商品が入っていたら、さらにカートに商品を入れる。そうでない場合は、メッセージを表示
if(isset($_SESSION['cart'])==true){
    $cart = $_SESSION['cart'];    
}
if(empty($_SESSION["cart"])){
    unset($_SESSION["cart"]);
}

// リロードからの数量変更の防止
$_SESSION['look_reload'] = 0;
$_SESSION['look_reload'] += 1;
if($_SESSION['reload']>=2){
    header('location: shop_cartlook.php');
    exit();
}

// カートに入っている商品を取り出す。
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
    <title>cartlook</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
    </style>
</head>
<body>
    <?php include('../header.php'); ?>
    <div class="container">
        <div class="row">
            <?php foreach($cart as $product): ?>
                <div class="col">
                    <h5>商品名：<?php echo es($product["name"]); ?></h5>
                        <img src="../../product/fruits_image/<?php echo es($product['image']); ?>" style="width:250px">
                    <p>値段：<?php echo $product["price"]; ?>　円</p>
                    <label>個数：</label>
                    <form action="num_change.php" method="post">
                        <select name="num">
                            <?php num_change($product["num"]); ?>
                        </select>
                        <input type="hidden" name="pro_code" value='<?php echo $product["pro_code"]; ?>'>
                        <input type="submit" value="数量変更">
                    </form>
                    <form action="../shop_delete.php" method="post">
                        <input name="delete" type="checkbox">
                        <input type="hidden" name="pro_code" value='<?php echo $product["pro_code"]; ?>'>
                        <input class="my-3" type="submit" value="カートから削除">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
            <?php if(isset($_SESSION['cart'])):?>
                <a class="btn btn-danger" href="clear_cart.php">カートをクリアする</a>
                <a class="btn btn-primary" href="../shop_form/shop_form.php">購入手続きに進む</a>
                <?php if(isset($_SESSION['member_login'])==true): ?>
                    <a href="../shop_form/easy_order.php">会員登録済みのお客様はこちら</a>
                <?php endif;?>
            <?php else: ?>
                <p>カートに商品は入っていません</p>
            <?php endif;?>
            <br>
            <a class="btn btn-secondary mt-3" href="../shop_list.php">戻る</a>
    </div>
</body>
</html>