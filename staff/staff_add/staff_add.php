<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

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
        <h3>スタッフ追加</h3>
        <div class="row">
            <div class="col">
                <form method="post" class="form-group" action="staff_add_check.php">
                    <label for="">スタッフ名を入力してください</label>
                    <input type="text" class="form-control" name="name">
                    <label for="">パスワードを入力してください</label><br>
                    <input type="password" name="password" class="form-control">
                    <label for="">パスワードをもう一度入力してください</label>
                    <input type="password" name="password2" class="form-control">
                    <br>
                    <input type="submit" class="form-control bg-primary" value="OK" style="width:200px;">
                    <br>
                    <input type="button" class="form-control bg-secondary" style="width:200px;" onclick="history.back()" value="戻る">
                </form>
            </div>
        </div>
    </div>
</body>
</html>