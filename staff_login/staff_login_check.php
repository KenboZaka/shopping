<?php
session_start();
session_regenerate_id(true);

require_once('../config/dbconnect.php');
require_once('../config/functions.php');

if(isset($_POST['code']) && isset($_POST['password'])){
    $staff_code = $_POST['code'];
    $staff_code = es($staff_code);

    $staff_password = es($_POST['password']);
    $staff_password = $staff_password;

}else{
    header('location: staff_login.html');
    exit();
}
// パスワードとスタッフコードがデータベース内にあるか確認。
$sql = "select name from mst_staff where code=? and password=?";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(
    $staff_code,
    sha1($staff_password)
));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if($result==false){
    header('location: staff_login.html');
    exit();
    // echo "パスワードまたはコードが不正です。";
}else{
    $_SESSION['login'] = 1;
    $_SESSION['staff_code'] = $staff_code;
    $_SESSION['staff_name'] = $result['name'];
    header('Location:staff_top.php');
    exit();
}
?>
