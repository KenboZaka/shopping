<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['cart'])==true){
    $cart = $_SESSION['cart'];
}
// 商品の商品コードと指定数量を受け取り、カートへ保存。　数量の登録は整数に変換
if(isset($_POST["num"]) && $_POST["pro_code"]){
    $num = $_POST["num"];
    $pro_code = $_POST["pro_code"];
    $cart[$pro_code]['num']= intval($num);

    $_SESSION['cart'] = $cart;
}

header("Location: ../shop_list.php");
exit;

