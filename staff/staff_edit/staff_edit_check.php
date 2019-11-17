<?php
session_start();
session_regenerate_id(true);

require_once('../../config/dbconnect.php');
require_once('../../config/functions.php');

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

if(isset($_POST['delete']) && isset($_POST['code'])){
    $staffcode = $_POST['code'];
    header('Location: ../staff_delete/staff_delete.php?code='.$staffcode);
    exit();
}

if(isset($_POST)){
    $staffcode = $_POST['code'];
    $name = $_POST['name'];
    $password = '表示されません';

    $name = es($name);
}else{
    echo "エラーが発生しました。再度お試しください";
}

$sql = 'update mst_staff set name=? where code=?';
$stmt = $dbh->prepare($sql);
$stmt->execute(array($name, $staffcode));

$dbh = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>edit_check</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>以下の情報に変更しました</h3>
        <div class="row">
            <div class="col">
                <ul>
                    <li><?php echo $staffcode; ?></li>
                    <li><?php echo $name; ?></li>
                    <li><?php echo $password; ?></li>
                </ul>
                <a href="../staff_list.php">リストに戻る</a>
            </div>
        </div>
    </div>
</body>
</html>