<?php
session_start();
session_regenerate_id(true);

require_once("../config/dbconnect.php");
require_once('../config/functions.php');

if(isset($_POST)){
    $post = es_for_post($_POST);
    $name = $post["name"];
    $email = $post["email"];
    $postal1 = $post["postal1"];
    $postal2 = $post["postal2"];
    $address = $post["address"];
    $tel = $post["tel"];
    $password = $post['password'];
    $birth = $post['birth'];
    $sex = $post['sex'];
}

$sql = 'lock tables dat_sales write, dat_sales_product write';
$stmt = $dbh->prepare($sql);

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

$sql = 'unlock tables';
$dbh = null;
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
    <?php include('../shop/header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>ありがとうございます！会員登録が完了しました。</h5>
            </div>
            <a href="../member_login/member_login.php">ログイン画面へ</a>
        </div>
    </div>
</body>
</html>