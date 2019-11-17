<?php
session_start();
session_regenerate_id(true);

// ログインしていない人が、いったんカートを空にする処理
$_SESSION = array();
if(isset($_COOKIE[session_name()])==true){
    setcookie(session_name(), '', time()-4200, '/');
}
session_destroy();

header('Location: ../shop_list.php');
exit();
?>
