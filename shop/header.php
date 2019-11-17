<?php
 session_start();
 session_regenerate_id(true);

?>
<header>
    <div class="jumbotron">
        <h1 style="color:red">shopping site</h1>
    <?php if(isset($_SESSION['member_login'])==false) :?>
        <h6>ようこそ、ゲスト様！</h6>
        <a class="float-right" href="../member_login/member_login.php">会員ログイン画面へ</a><br>
        <a class="float-right" href="../register/register_form.php">新規登録へ</a>
    <?php else: ?>
        <h6>ようこそ！</h6>
        <h6><?php echo $_SESSION['member_name'];?>様</h6>
        <br>
        <a class="float-right" href="../member_login/member_logout.php">ログアウト</a>
    <?php endif; ?>
    </div>
</header>