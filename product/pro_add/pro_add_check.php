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
    
    if($_POST['name']==='' || $_POST['price']===""){
        header('Location:pro_add.php');
        exit();
    }
    if(isset($_POST['name'])){
        $pro_name = $_POST['name'];
        $pro_name = es($pro_name);
    }
    if(isset($_POST['price'])){
        $pro_price = $_POST['price'];
        $pro_price = es($pro_price);
    }
    if(isset($_FILES['image'])){
        $pro_image = $_FILES['image'];
        if($pro_image['size'] > 300000){
            echo '画像が大きすぎます';
        }else{
            move_uploaded_file($pro_image['tmp_name'],'../fruits_image/'.$pro_image['name']);
        }
    }
    
    $error = [];
    if(preg_match('/¥A[0-9]+¥z/', $pro_name) == 0){
        $error[] = "商品名を正しく入力してください";
    }
    if(preg_match('/¥A[0-9]+¥z/', $pro_price)== 0 || ($_POST['price']==='')){
        $error[] = "価格は半角で入力してください";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>add_check</title>
</head>
<body>
    <div class="container">
        <h3>こちらを追加します</h3>
        <div class="row">
            <div class="col">
                <ul>
                    <li><?php echo $pro_name; ?></li>
                    <li><?php echo $pro_price; ?>円</li>
                    <img src="../fruits_image/<?php echo $pro_image['name'] ;?>" width="300">
                </ul>
                    <form action="pro_add_done.php" method="post">
                        <input type="hidden" name="name" value="<?php echo $pro_name; ?>">
                        <input type="hidden" name="price" value="<?php echo $pro_price; ?>">
                        <input type="hidden" name="image" value="<?php echo $pro_image['name']; ?>">
                        <input type="submit" value="登録する">
                    </form>
            </div>
        </div>
    </div>
</body>
</html>