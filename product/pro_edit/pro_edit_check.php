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

    if($_FILES['new_image']!==null){
        $pro_new_image = $_FILES['new_image'];
        if($pro_new_image['size'] > 3000000){
            echo "サイズが大きすぎます";
        }else{
            move_uploaded_file($pro_new_image['tmp_name'],'../fruits_image/'.$pro_new_image['name']);
            $pro_image = $pro_new_image['name'];
        }
    }else{
        $pro_image = $_POST['old_image'];
    }

    $pro_code = $_POST['procode'];
    $pro_name = $_POST['name'];
    $pro_price = $_POST['price'];
    $sql = 'update mst_product set name=?, price=?, image=? where code=?';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $pro_name,
        $pro_price,
        $pro_image,
        $pro_code
    ]);
// echo "既存";
// var_dump($_POST['old_image']);
// echo "新規";
var_dump($_FILES['new_image']);
// echo "こーど";
// var_dump($pro_image);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>edit_check</title>
</head>
<body>
    <div class="container">
    <h5><?php echo $staff_name?>がログイン中です。</h5>
    <h3>以下の商品を登録しました</h3>
    <div class="row">
        <div class="col">
        <p>以下の情報に更新しました。</p>
            <ul>
                <li><?php echo $pro_name; ?></li>
                <li><?php echo $pro_price; ?></li>
            </ul>
                <img src="../fruits_image/<?php echo es($pro_image); ?>" width="300"><br>
            <a class="btn btn-secondary" style="width:200px;" href="../pro_list.php">戻る</a>
        </div>
    </div>
    </div>
</body>
</html>
