<?php
    session_start();
    session_regenerate_id(true);

    require_once('../../config/dbconnect.php');

// すでにメンバー登録されている人だったら、登録情報を取り出し記入済みにする
if(isset($_SESSION['member_login'])==true){
    $member_code = $_SESSION['member_code'];
    $sql = "select name, email, postal1, postal2, address, tel from dat_member where code=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $member_code
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $result["name"];
    $email = $result["email"];
    $postal1 = $result["postal1"];
    $postal2 = $result["postal2"];
    $address = $result["address"];
    $tel = $result["tel"];
    $order = $result['order'];
}else{
    echo "会員登録情報がありません。";
    echo '<a href="shop_cartlook.php"></a>';
}
?>
<!DOCTYPE html>
<html lang="en">
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
    <?php include('header.php'); ?>
    <div class="container">
        <h5>こちらの情報で間違いありませんか？</h5>
        <form class="form-group" method="post" action="shop_form_check.php">
            <label for="name">お名前：</label><br>
            <input class="form-control" type="text" name="name" value='<?php echo $name; ?>'><br>
            <label for="email">Eメールアドレス：</label><br>
            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>"><br>
            <label for="postal">郵便番号：</label><br>
            <input class="form-control-sm" type="text" name="postal1" value="<?php echo $postal1; ?>">-<input class="form-control-sm" type="text" name="postal2" value="<?php echo $postal2; ?>"><br>
            <label class="mt-4" for="address">住所：</label><br>
            <input class="form-control" type="text" name="address" value="<?php echo $address; ?>"><br>
            <label for="tel">電話番号：</label><br>
            <input class="form-control" type="text" name="tel" value="<?php echo $tel; ?>"><br>
            <input class="btn btn-primary form-control my-3" type="submit" value="購入手続きにすすむ"><br>
            <input class="btn btn-secondary form-control my-1" type="button" onclick="history.back()" value="戻る"><br>
        </form>
    </div>
</body>
</html>