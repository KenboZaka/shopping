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

    $sql = "select code, name, price, image from mst_product";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>product list</title>
</head>
<body>
    <div class="container px-1">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>商品一覧</h3>
        <div class="row">
                <?php foreach($products as $product): ?>
            <div class="col-3">
                <form action="pro_branch.php" method="post" class="form-group">
                <div class="row">
                    <div class="col p-0">
                        <input type="radio" name="procode" value="<?php echo $product['code']; ?>"><?php echo es($product['name']); ?><br>
                        <img class="border" src="./fruits_image/<?php echo es($product['image']); ?>" width="100" height="80"><br>
                        <?php echo es($product['price']); ?>円<br>
                    </div>
                    <div class="col px-0">
                        <input type="submit" name="display" value="参照" class="form-control bg-primary" style="width:100px;">
                        <input type="submit" name="edit" value="修正" class="form-control bg-success" style="width:100px;">
                        <input type="submit" name="delete" value="削除" class="form-control bg-danger" style="width:100px;">
                    </div>
                </div>
                <hr>
                </form>
            </div>
                <?php endforeach; ?>
        </div>
            <hr>
                <form action="pro_branch.php" method="post" class="form-group">
                    <input type="submit" class="form-control" name="add" value="追加する" style="width:100px;">
                </form>
    </div>
</body>
</html>