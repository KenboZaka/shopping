<?php
session_start();
session_regenerate_id(true);

require_once('../config/dbconnect.php');
require_once('../config/functions.php');

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

if(isset($_REQUEST['code'])){
    $staffcode = $_REQUEST['code'];
}else{
    header('Location:staff_list.php');
    exit();
}

$sql = 'select * from mst_staff where code=?';
$stmt = $dbh->prepare($sql);
$stmt->execute([
    $staffcode]
    );
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff_branch</title>
</head>
<body>
    <div>
    <h3>スタッフ情報</h3>
        <ul>
            <li><?php echo $staff['code']; ?></li>
            <li><?php echo es($staff['name']); ?></li>
        </ul>
    </div>
</body>
</html>

