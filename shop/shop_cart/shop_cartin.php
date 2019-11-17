<?php
session_start();
session_regenerate_id(true);

require_once('../../config/dbconnect.php');
require_once('../../config/functions.php');

// 商品コードを取得
$pro_code = $_GET['procode'];

// すでにカートに商品をいれていたら($_SESSIONに商品があったら)、変数$cartへ代入し取り出せるようにする
$cart = [];
if(isset($_SESSION['cart'])==true){
    $cart = $_SESSION['cart'];
}

// プロダクトIDをセッション['cart']に入れる
// すでに同じ商品がカートに入っていたら、カートの数量($cart[$pro_code]['num'])をプラス1する
if($cart[$pro_code]['reload_count'] < 2){
    if(isset($cart[$pro_code])){
        $cart[$pro_code]['num'] ++;
        $cart[$pro_code]['reload_count'] ++;
    }else{
        // カートに同じ商品が入っていなかったら、新たに商品スペースを作成し、['num']に数量1を入れる
        $cart[$pro_code]=[];
        $cart[$pro_code]['pro_code'] = $pro_code;
        $cart[$pro_code]['num']= 1;
        $cart[$pro_code]['reload_count']= 1;
        $cart[$pro_code]['reload_count'] ++;
    }
    // セッションに記録する
    $_SESSION['cart'] = $cart;
}else{
    header('Location: ../shop_list.php');
    exit();
}

foreach($cart as $key => $val){
    $sql = "select name, price, image from mst_product where code = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $val['pro_code']
        ]);
    $master = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart[$key]['name'] = $master["name"];
    $cart[$key]['price'] = $master["price"];
    $cart[$key]['image'] = $master["image"];
    }
    
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Cart_in</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
    </style>
</head>
<body>
    <?php include('../header.php'); ?>
    <div class="container">
        <h3>カートに追加しました</h3>
        <div class="row">
            <?php foreach($cart as $key => $val):?>
                <div class="col">
                    <img class="border" src="../../product/fruits_image/<?php echo es($val['image']); ?>" style="width:250px">
                    <p><?php echo $val["name"]; ?></p>
                    <p><?php echo $val["num"]; ?>個</p>
                    <p>合計：<?php echo $val["price"] * $val["num"]; ?>円</p>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="../shop_list.php">商品一覧に戻る</a>
    </div>
</body>
</html>