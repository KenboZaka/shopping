<?php
    session_start();
    session_regenerate_id(true);

    require_once('../config/dbconnect.php');
    require_once('../config/functions.php');

    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }
    $staff_name = $_SESSION['staff_name'];
    $pro_code = $_GET['procode'];

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
    <title>詳細</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>商品詳細</h3>
        <div class="row">
            <div class="col">
                <p>商品名：<?php echo es($product['name']); ?></p>
                <img src="./fruits_image/<?php echo es($product['image']); ?>" width="300">
                <p>価格：<?php echo es($product['price']); ?>円</p>
                <a href="pro_list.php">戻る</a>
            </div>
        </div>
    </div>
</body>
</html>