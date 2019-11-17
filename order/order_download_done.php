<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

require_once('../config/dbconnect.php');

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];

$sql = 'select dat_sales.code, dat_sales.date, dat_sales.code_member, dat_sales.name as dat_sales_name, dat_sales.email, dat_sales.postal1,dat_sales.postal2, dat_sales.address, dat_sales.tel, dat_sales_product.code_product, mst_product.name as mst_product_name, dat_sales_product.price, dat_sales_product.quantity from dat_sales, dat_sales_product, mst_product where dat_sales.code = dat_sales_product.code_sales and dat_sales_product.code_product = mst_product.code and substr(dat_sales.date,1,4) = ? and substr(dat_sales.date, 6,2) =? and substr(dat_sales.date, 9, 2) = ?';

$stmt = $dbh->prepare($sql);
$stmt->execute([
    $year,
    $month,
    $day
]);

$csv = '注文コード, 注文日時, 会員番号, お名前, メール, 郵便番号, 住所, TEL, 商品コード, 商品名, 価格, 数量';
$csv .= "\n";

$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $key => $value){
    $csv .= $value['code'].',';
    $csv .= $value['date'].',';
    $csv .= $value['code_member'].',';
    $csv .= $value['dat_sales_name'].',';
    $csv .= $value['email'].',';
    $csv .= $value['postal1'].'-'.$value['postal2'].',';
    $csv .= $value['address'].',';
    $csv .= $value['tel'].',';
    $csv .= $value['code_product'].',';
    $csv .= $value['mst_product_name'].',';
    $csv .= $value['price'].',';
    $csv .= $value['quantity']."\n";
}

$file = fopen('./chumon.csv', 'w');
$csv = mb_convert_encoding($csv, 'UTF-8');
fputs($file, $csv);
fclose($file);
?>

<a href="chumon.csv">注文データのダウンロード</a><br>
<br>
<a href="order_download.php">日付選択へ</a><br>
<br>
<a href="../staff_login/staff_top.php">トップメニューへ</a><br>

