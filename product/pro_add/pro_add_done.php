<?php
    session_start();
    session_regenerate_id(true);

    require_once('../../config/dbconnect.php');
    require_once('../../config/functions.php');

    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }

    if(isset($_POST['name'])){
        $pro_name = $_POST['name'];
    }
    if(isset($_POST['price'])){
        $pro_price = $_POST['price'];
    }
    if(isset($_POST['image'])){
        $pro_image = $_POST['image'];
    }

    $sql = "insert into mst_product (name, price, image) values(?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $pro_name,
        $pro_price,
        $pro_image
    ]);
    $dbh->null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Done</title>
</head>
<body>
    <div class="container">
        <h3>以下の商品を登録しました</h3>
        <div class="row">
            <div class="col">
                <ul>
                    <li><?php echo $pro_name; ?></li>
                    <li><?php echo $pro_price; ?></li>
                    <li><?php echo $pro_image; ?></li>
                </ul>
                <a href="../pro_list.php">リストを確認</a>
            </div>
        </div>
    </div>
</body>
</html>