<?php
session_start();
session_regenerate_id();
$cart = $_SESSION["cart"];

// カートのセッションから商品を削除する
if(isset($_POST['delete'])==true && $_POST["pro_code"]){
    $pro_code = $_POST["pro_code"];
    unset($cart[$pro_code]);
    $_SESSION['cart'] = $cart;
}

header("Location: ./shop_cart/shop_cartlook.php");
exit;

?>