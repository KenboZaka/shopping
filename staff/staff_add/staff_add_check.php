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

if($_POST['name']===""){
    echo 'スタッフ名が入力されていません。<bt>';
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}
if($password == "" || $password2 == ""){
    echo 'パスワードが入力されていません。<bt>';
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}
if($password !== $password2){
    echo 'パスワードが一致しません。<br>';
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}

$new_staff  = $_POST['name'];
$password  = $_POST['password'];
$password2  = $_POST['password2'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff_add</title>
</head>
<body>
    <div class="container">
    <h5><?php echo $staff_name?>がログイン中です。</h5>
        <div class="row">
            <div class="col">
                <h5>以下の情報で登録します。</h5>
                    <ul>
                        <li><?php echo $staff_name; ?></li>
                        <li>パスワードは表示されません</li>
                    </ul>
                <form action="staff_add_done.php" method="post" class="form-group">
                    <input type="hidden" name="name" value="<?php echo $staff_name; ?>">
                    <input type="hidden" name="password" value="<?php echo $password; ?>">
                    <input type="submit" class="form-control" value="OK">
                    <input type="button" class="form-control" onclick="history.back()" value="戻る">
                </form>
            </div>
        </div>
    </div>
</body>
</html>