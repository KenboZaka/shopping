<?php
session_start();
session_regenerate_id(true);
$cart = $_SESSION["cart"];

require_once("../../config/dbconnect.php");
require_once('../../config/functions.php');

if(isset($_POST)){
    // ポストで送られてきた情報を全てエスケープしたあと、それぞれの変数へ格納
    $post = es_for_post($_POST);
    $name = $post["name"];
    $email = $post["email"];
    $postal1 = $post["postal1"];
    $postal2 = $post["postal2"];
    $address = $post["address"];
    $tel = $post["tel"];
    $order = $post['order'];
    $password = $post['password'];
    if(isset($post['birth'])){
        $birth = $post['birth'];
    }else{
        $birth = null;
    }
    if(isset($post['sex'])){
        $sex = $post['sex'];
    }else{
        $sex = null;
    }
}
// 同時登録がされない様にデータベースにロックをかける処理
$sql = 'lock tables dat_sales write, dat_sales_product write';
$stmt = $dbh->prepare($sql);

foreach($cart as $key => $value){
    $sql = 'select * from mst_product where code = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $value["pro_code"]
    ]);
    // 購入する商品もカートに入れる処理をする
    $master = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart[$key]['name'] = $master['name'];
    $cart[$key]['price'] = $master['price'];
    $cart[$key]['image'] = $master['image'];
}

// すでに登録済みの会員か、または今回会員登録をする人の場合は、会員識別のコードを1として、購入記録データに記録する
if($order==='member_register' || $_SESSION['member_login'] == 1){
    $code_member = 1;
}else{
    $code_member = 0;
}
$sql = 'insert into dat_sales(code_member, name, email, postal1, postal2, address, tel)values(?,?,?,?,?,?,?)';
$stmt = $dbh->prepare($sql);
$stmt->execute([
    $code_member,
    $name,
    $email, 
    $postal1,
    $postal2,
    $address,
    $tel
]);

$sql = 'select last_insert_id()';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$last_code = $rec["last_insert_id()"];

foreach($cart as $key => $value){
    $sql = 'insert into dat_sales_product(code_sales, code_product, price, quantity) values(?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $last_code,
        $value['pro_code'],
        $cart[$key]['price'],
        $cart[$key]['num']
    ]);
}

// テーブルロックを解除
$sql = 'unlock tables';
$stmt = $dbh->prepare($sql);
$stmt->execute();
// 会員登録を希望の場合は、会員データに記録する処理を行う。　パスワードは暗号化
if($order === 'member_register'){
    $sql = "insert into dat_member(password, name, email, postal1, postal2, address, tel, sex, birth)values(:password, :name, :email, :postal1, :postal2, :address, :tel, :sex, :birth)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':postal1', $postal1, PDO::PARAM_STR);
    $stmt->bindValue(':postal2', $postal2, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindValue(':sex', $sex, PDO::PARAM_STR);
    $stmt->bindValue(':birth', $birth, PDO::PARAM_STR);
    $stmt->execute();
}

$dbh = null;

// メールの内容
$mail_content = $name."様、この度はご注文ありがとうございました。\n".'以下の内容で承りました'."\n";
foreach($cart as $product){
    $mail_content .= $product['name'].':'.$product['price']. 'x' .$product['num']. '=' .getPrice($product['price'], $product['num']).'円'."\n";
    $ttlPrice += getPrice($product["price"], $product['num']);
}
$mail_content .= '合計：'.$ttlPrice.'円  (送料は無料です)'."\n";
$mail_content .= '<hr>';
$mail_content .= '商品は以下の住所へ発送予定です。'."\n".'住所：〒'.$postal1.'-'.$postal2.'  '.$address."\n";
$mail_content .= '確認用電話番号：'.$tel."\n";
$mail_content .= '-----------------------------'."\n".'~けんぼう菜園'."\n".'福岡県久留米市12-1　電話：0942-45-6748'."\n".'E-mail: kenbo@gmail.com'."\n".'代金は以下の口座にお支払いください'."\n".'ろくまる銀行　やさい支店　普通口座　1234567'."\n".'-----------------------------'."\n".'入金確認が取れ次第、梱包、発送させていただきます'."\n";

// お客様へのメール送信
$title = "ご注文ありがとうございます。けんぼう菜園です";
$header = 'From: info@kenbo.co.jp';
$mail_content = nl2br($mail_content);
$mail_content = html_entity_decode($mail_content, ENT_QUOTES, 'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail($email, $title, $mail_content, $header);

// 店舗へのメール送信
$title = "お客様からご注文がありました。";
$header = 'From: '.$email;
$mail_content = nl2br($mail_content);
$mail_content = html_entity_decode($mail_content, ENT_QUOTES, 'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail('kenbo@gmail.com', $title, $mail_content, $header);

$ttlPrice = 0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Registration complete</title>
    <style>
        body{
            background-color:#CCFFFF;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h5><?php echo $name; ?>様、この度はご注文ありがとうございました。</h5>
        <p><?php echo $email; ?>へ確認メールを送信しましたのでご確認ください</p>
            <?php foreach($cart as $product): ?>
                <p><?php echo $product['name']; ?>: <?php echo $product["price"] ;?>x<?php echo $product['num']; ?> = 
                <?php getIncluded($product["price"], $product['num']) ;?>　円（税込）</p>
                <?php $ttlPrice += getPrice($product["price"], $product['num']) ;?>
            <?php endforeach; ?>
            <p>合計：<?php echo $ttlPrice ;?>　円</p>
            <p>送料は無料です</p>
            <hr>
            <p>商品は以下の住所へ発送予定です。</p>
            <p>住所：〒<?php echo $postal1,"-", $postal2; ?>　<?php echo $address; ?></p>
            <p>確認用電話番号：<?php echo $tel?></p>

            <p>-----------------------------</p>
            <p>~おいしいさ満点！けんぼう菜園</p>
            <p>福岡県久留米市12-1　電話：0942-45-6748</p>
            <p>E-mail: kenbo@gmail.com</p>
            <p>代金は以下の口座にお支払いください</p>
            <p>ろくまる銀行　やさい支店　普通口座　1234567</p>
            <p>-----------------------------</p>
            <p>入金確認が取れ次第、梱包、発送させていただきます</p>
            <a href="../shop_cart/cart_clear_shop_list.php">戻る</a>
    </div>
</body>
</html>