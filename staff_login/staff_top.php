<?php
session_start();
session_regenerate_id(true);

require_once('../config/functions.php');

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff_top</title>
</head>
<body>
    <div class="container">
        <h3>ようこそ!<?php echo es($staff_name); ?>さん</h3>
        <h3>ショップ管理トップメニュー</h3><br>
        <div class="row">
            <div class="col">
                <a class="btn btn-primary my-1" href="../staff/staff_list.php">スタッフ管理</a>
                <a class="btn btn-primary my-2" href="../order/order_download.php">注文ダウンロード</a>
                <a class="btn btn-primary my-2" href="../product/pro_list.php">商品管理</a>
                <a class="btn btn-secondary my-2" href="staff_logout.php">ログアウト</a>
            </div>
        </div>
    </div>
</body>
</html>