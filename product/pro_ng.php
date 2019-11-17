<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }
    echo "<h3>商品が選択されていません</h3>";
    echo '<a href="pro_list.php">戻る</a>';
?>