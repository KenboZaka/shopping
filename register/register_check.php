<?php
session_start();
session_regenerate_id(true);

require_once('../config/functions.php');

// 関数でまとめてエスケープ処理
if(isset($_POST)){
    $post = es_for_post($_POST);
}
$name = $post["name"];
$email = $post["email"];
$postal1 = $post["postal1"];
$postal2 = $post["postal2"];
$address = $post["address"];
$tel = $post["tel"];
$pass = $post['pass'];
$pass2 = $post['pass2'];
$sex = $post['sex'];
$birth = $post['birth'];

$okflag = true;
if($name == ""){
    $okflag = false;
    $error['name'] = '名前が入力されていません';
}

if(!preg_match('/\A[\w\\.]+\@[\w\\.]+\.([a-z]+)\z/' ,$email) || $email == ""){
    $okflag = false;
    $error['email'] = "メールアドレスが不正です";
}
if(!preg_match('/\A[0-9]+\z/', $postal1) || $postal1 == ""){
    $okflag = false;
    $error["postal"] = "郵便番号が不正です";
}
if(!preg_match('/\A[0-9]+\z/', $postal2) || $postal2 == ""){
    $okflag = false;
    $error["postal"] = "郵便番号が不正です";
}
if($address == ''){
    $okflag = false;
    $error['address'] = "住所が入力されていません";
}
if(!preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel)){
    $okflag = false;
    $error['tel'] = "電話番号が正しく入力されていません";
}

if($order === "member_register"){
    if($pass === ""){
        $okflag = false;
        $error['password'] = "パスワードが入力されていません";
    }
    if($pass !== $pass2){
        $okflag = false;
        $error['wrong_pass'] = "入力パスワードが一致しません";
    }
}
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
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <?php include('../shop/header.php'); ?>
    <div class="container">
        <h5>入力内容に間違いありませんか？</h5>
        <form class="form-group" method="post" action="register_done.php">
            <!-- 名前登録　バリデーション -->
            <?php if(isset($error['name'])): ?>
                <p class="error"><?php echo $error['name']; ?></p><br>
            <?php else: ?>
                <label for="name">お名前：</label><br>
                <input class="form-control" type="text" name="name" value='<?php echo $name; ?>'><br>
            <?php endif; ?>
            <!-- email登録　バリデーション -->
            <?php if(isset($error['email'])): ?>
                <p class="error"><?php echo $error['email']; ?></p><br>
            <?php else:?>
                <label for="email">Eメールアドレス：</label><br>
                <input class="form-control" type="text" name="email" value="<?php echo $email; ?>"><br>
            <?php endif; ?>
            <!-- 郵便番号1, 2登録　バリデーション -->
            <?php if(isset($error['postal'])): ?>
                <p class="error"><?php echo $error["postal"]; ?></p><br>
            <?php else: ?>
                <label for="postal">郵便番号：</label><br>
                <input class="form-control-sm" type="text" name="postal1" value="<?php echo $postal1; ?>">-<input class="form-control-sm" type="text" name="postal2" value="<?php echo $postal2; ?>"><br>
            <?php endif; ?>
            <!-- 住所登録　バリデーション -->
            <?php if(isset($error['address'])): ?>
                <p class="error"><?php echo $error['address']; ?></p><br>
            <?php else:?>
                <label class="mt-4" for="address">住所：</label><br>
                <input class="form-control" type="text" name="address" value="<?php echo $address; ?>"><br>
            <?php endif; ?>
            <!-- 電話番号　バリデーション -->
            <?php if(isset($error['tel'])): ?>
                <p class="error"><?php echo $error['tel']; ?></p><br>
            <?php else:?>
                <label for="tel">電話番号：</label><br>
                <input class="form-control" type="text" name="tel" value="<?php echo $tel; ?>"><br>
            <?php endif; ?>

                <?php if(isset($error['password'])): ?>
                    <p class="error"><?php echo $error['password']; ?></p><br>
                <?php elseif(isset($error['wrong_pass'])):?>
                    <p class="error"><?php echo $error['wrong_pass']; ?></p><br>
                <?php else: ?>
                <!-- パスワード -->
                    <label for="tel">パスワード：</label><br>
                    <p>表示されません</p>
                    <input class="form-control" type="hidden" name="password" value="<?php echo $pass; ?>">
                <?php endif; ?>
                <!-- 性別表示 -->
                <label for="sex">性別：</label><br>
                <?php if($sex === "man"): ?>
                    <p>男性</p><br>
                    <input class="form-control" type="hidden" name="sex" value="<?php echo $sex; ?>">
                <?php elseif($sex === "woman"):?>
                    <p>女性</p><br>
                    <input class="form-control" type="hidden" name="sex" value="<?php echo $sex; ?>">
                <?php endif; ?>
                <!-- 誕生日登録 -->
                <?php if(isset($error['birth'])): ?>
                    <p class="error"><?php echo $error['birth']; ?></p>
                <?php else: ?>
                    <label for="sex">性別：</label><br>
                    <p><?php echo $birth; ?>年代</p>
                    <input type="hidden" name="birth" value="<?php echo $birth; ?>">
                <?php endif; ?>

            <!-- 入力内容問題なく通過したら、登録ボタンを表示 -->
            <?php if($okflag == true): ?>
                <input class="btn btn-primary form-control my-3" type="submit" value="登録"><br>
            <?php endif; ?>
                <input class="btn btn-secondary form-control my-1" type="button" onclick="history.back()" value="戻る"><br>
        </form>
    </div>
</body>
</html>