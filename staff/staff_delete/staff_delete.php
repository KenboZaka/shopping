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

if(isset($_REQUEST['code'])){
    $staffcode = $_REQUEST['code'];
}

$sql = 'select * from mst_staff where code=?';
$stmt = $dbh->prepare($sql);
$stmt->execute([
    $staffcode
    ]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

$dbh = null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>confirm delete</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $staff_name?>がログイン中です。</h5>
        <h3>以下の情報を削除してよろしいですか</h3>
        <div class="row">
            <div class="col">
                <ul>
                    <li><?php echo $staff['code']; ?></li>
                    <li><?php echo $staff['name']; ?></li>
                </ul>
                <form action="staff_delete_done.php" class="form-group" method="post">
                    <input type="hidden" name="code" value="<?php echo $staff['code']?>">
                    <input type="submit" class="form-control bg-danger" value="OK" style="width:200px;">
                </form>
                    <a href="../staff_list.php"class="btn btn-secondary" value="戻る" style="width:200px;">戻る</a>
            </div>
        </div>
    </div>
</body>
</html>

