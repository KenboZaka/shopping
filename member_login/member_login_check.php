<?php
    require_once('../config/dbconnect.php');
    require_once('../config/functions.php');

    // 登録フォームから送られてきたメアドとパスワードをエスケープ&暗号化解除
    if(isset($_POST['email']) && isset($_POST['password'])){
        $member_email = es($_POST['email']);
        $member_password = es($_POST['password']);
        $member_password = sha1($member_password);
    }else{
        echo "入力してください";
        echo '<a href="member_login.php">戻る</a>';
    }

    // データベースに該当のメアド、パスワードがあるか確認する
    $sql = "select code, name from dat_member where email=? and password=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $member_email,
        $member_password
    ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // データベースに該当のデータがfalseの場合はメッセージ。　あればセッションへ保存し、ログイン完了し商品リストページへ移動　
    if($result==false){
        echo "パスワードまたはコードが不正です。";
        echo '<a href="member_login.php">戻る</a>';
    }else{
        session_start();
        session_regenerate_id(true);
        $_SESSION['member_login'] = 1;
        $_SESSION['member_email'] = $member_email;
        $_SESSION['member_code'] = $result['code'];
        $_SESSION['member_name'] = $result['name'];
        header('Location:../shop/shop_list.php');
        exit();
    }
?>
