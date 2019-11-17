<?php
    session_start();

    // 一度セッションを空にする処理をおこない、新たにログインしてもらう様にする
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
    <title>member_login</title>
</head>
<body>
    <div class="container">
        <h3 class="mt-5">会員ログイン</h3>
        <div class="row">
            <div class="col mt-4">
                <form method="post" class="form-group" action="member_login_check.php">
                    <label for="email">会員メールアドレス：</label>
                        <input type="text" class="form-control" name="email"><br>
                    <label for="password">パスワード：</label>
                        <input type="password" class="form-control" name="password"><br>
                    <input type="submit" class="form-control" value="ログイン">
                </form>
                <a href="../shop/shop_list.php">商品ページへ戻る</a>
            </div>
        </div>
    </div>
</body>
</html>