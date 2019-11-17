<?php
    session_start();
    session_regenerate_id(true);

    require_once('../../config/dbconnect.php');
    require_once('../../config/functions.php');

    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }
    $staff_name = $_SESSION['staff_name'];
    $pro_code = $_GET['procode'];

    $sql = "select code, name, price, image from mst_product where code=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $pro_code
    ]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Staff_Add</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>商品情報編集</h3>
        <div class="row">
            <div class="col">
                <form method="post" action="pro_edit_check.php" class="form-group" enctype="multipart/form-data">
                    <input type="hidden" name="procode" value="<?php echo $product['code']; ?>">
                    商品名：<input type="text" class="form-control" name="name" style="width:200px" value="<?php echo es($product['name']); ?>">
                    価格：<input type="text" class="form-control" name="price" style="width:200px" value="<?php echo $product['price']; ?>"><br>
                    <?php if($product['image']): ?>
                        <img src="../fruits_image/<?php echo $product['image']?>" width="300"><br>
                        <label for="">画像を変更できます
                            <input type="file" name='new_image' style="width:400px">
                            <input type="hidden" name='old_image' value="<?php echo $product['image']; ?>" style="width:400px"><br>
                        </label>
                    <?php else: ?>
                        <label for="">画像を選択できます
                            <input type="file" name='new_image' style="width:400px">
                        </label>
                    <?php endif; ?>
                    <input type="button" onclick="history.back()" class="form-control bg-secondary" style="width:200px" value="戻る">
                    <input type="submit" class="form-control bg-primary" style="width:200px" value="OK">
                </form>
            </div>
        </div>
    </div>
</body>
</html>