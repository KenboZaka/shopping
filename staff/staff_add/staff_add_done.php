<?php
session_start();
session_regenerate_id(true);

require_once('../../config/dbconnect.php');
require_once('../../config/functions.php');

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

if(isset($_POST['name']) && isset($_POST['password'])){
    $new_staff  = $_POST['name'];
    $password  = $_POST['password'];
    
    $sql = 'insert into mst_staff(name, password) values(?, ?)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        $new_staff, 
        sha1($password)
        ]);
    $dbh = NULL;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff_add_done</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h5><?php echo es($new_staff); ?>を追加しました。</h5>
        <div class="row">
            <a href="../staff_list.php">戻る</a>    
        </div>
    </div>
</body>
</html>