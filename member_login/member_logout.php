<?php
    session_start();

    // ログアウト処理。セッションを空にする
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])==true){
        setcookie(session_name(), '', time()-4200, '/');
    }
    session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>member_logout</title>
</head>
<body>
    <div>
    <h3>ログアウトしました</h3>
    <a href="member_login.php">ログイン画面へ</a><br>
    <a href="../shop/shop_list.php">商品ページへ</a>
    </div>
</body>
</html>