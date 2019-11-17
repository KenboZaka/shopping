<?php
session_start();
session_regenerate_id(true);

require_once('../../config/functions.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>shop_form</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
    </style>
</head>
<body>
    <?php include('../header.php'); ?>
    <div class="container">
        <h5>お客様情報を入力してください</h5>
        <?php if(isset($_SESSION['member_login'])==true): ?>
            <a class="btn btn-primary" href="easy_order.php">会員登録済みのお客様はこちら</a>
        <?php endif;?>
        <form class="form-group" method="post" action="shop_form_check.php">
            <label for="name">お名前：</label><br>
            <input class="form-control" type="text" name="name"><br>
            <label for="email">Eメールアドレス：</label><br>
            <input class="form-control" type="text" name="email"><br>
            <label for="postal">郵便番号：</label><br>
            <input class="form-control-sm" type="text" name="postal1">-<input class="form-control-sm" type="text" name="postal2"><br>
            <label class="mt-4" for="address">住所：</label><br>
            <input class="form-control" type="text" name="address"><br>
            <label for="tel">電話番号：</label><br>
            <input class="form-control" type="text" name="tel"><br>
            <br>
            <label for="order">今回だけ注文</label>
            <input type="radio" name="order" value="once" checked><br>
            <label for="order">会員登録して注文</label>
            <input type="radio" name="order" value="member_register"><br>

            会員登録する方は以下の項目も入力してください。<br>
            <label for="password">パスワード入力してください。</label><br>
            <input class="form-control" type="password" name="pass"><br>
            <label for="password">パスワードをもう一度入力してください。</label><br>
            <input class="form-control" type="password" name="pass2"><br>
            <label for="sex">性別</label><br>
            <label for="man">男性
            <input class="form-control" type="radio" name="sex" value="man" checked></label>
            <label for="woman">女性
            <input class="form-control" type="radio" name="sex" value="woman"></label><br>
            <label for="sex">生まれ年</label><br>
            <select class="form-contorl" name="birth">
                <?php generation(); ?>
            </select>
            <input class="btn btn-primary form-control my-3" type="submit" value="OK"><br>
            <input class="btn btn-secondary form-control my-1" type="button" onclick="history.back()" value="戻る"><br>
        </form>
    </div>
</body>
</html>