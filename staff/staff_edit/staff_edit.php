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

if(isset($_POST['staffcode'])){
    $staff_code = $_POST['staffcode'];
}else{
    header('Location:staff_list.php');
    exit();
}

$sql = "select * from mst_staff where code = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([
    $staff_code
    ]);
$dbh = null;

$staff = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Staff_Add</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>スタッフ編集</h3>
        <div class="row">
            <div class="col">
                <form method="post" class="form-group" action="staff_edit_check.php">
                    <label for="">スタッフ名を入力してください</label><br>
                    <input type="hidden" name="code" value="<?php echo $staff['code']; ?>">
                    <input type="text" class="form-control" name="name" style="width:200px" value="<?php echo es($staff['name']); ?>"><br>
                    <input type="hidden" name="password" value="<?php echo $staff['password']; ?>">
                    <input type="submit" class="form-control my-2 bg-primary" value="OK" style="width:200px;">
                    <input type="submit" class="form-control bg-danger" name="delete" value="削除する" style="width:200px;">
                    <input type="button" class="form-control my-2 bg-secondary" onclick="history.back()" value="戻る" style="width:200px;">
                </form>
            </div>
        </div>
    </div>
</body>
</html>