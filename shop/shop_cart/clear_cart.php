<?php
    session_start();
    session_regenerate_id(true);

    // カートの中身を空にする処理
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])==true){
        setcookie(session_name(), '', time()-4200, '/');
    }
    session_destroy();
    echo "カートを空にしました";
    echo '<a href="../shop_list.php">戻る</a>';
?>

