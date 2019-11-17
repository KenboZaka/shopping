<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>pro_add</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="pro_add_check.php" method="post" enctype="multipart/form-data">
                    <label for="">商品名：
                        <input type="text" name="name" style="width:200px">
                    </label><br>
                    <label for="">価格：
                        <input type="text" name="price" style="width:50px">
                    </label><br>
                    <label for="">画像：
                        <input type="file" name="image" style="width:400px">
                    </label><br>
                    <input type="submit" value="確認する">
                </form>
            </div>
        </div>
    </div>
</body>
</html>