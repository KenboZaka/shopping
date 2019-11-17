<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo "ログインされていません";
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
        exit();
    }
    $staff_name = $_SESSION['staff_name'];

    require_once('../config/functions.php');

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff_top</title>
</head>
<body>
    <h5>ダウンロードしたい注文日を選んでください</h5>
        <form action="order_download_done.php" method="post">
            <select name="year">
              <option value="2017">2017</option>
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
            </select>
            年
            <select name="month">
                <?php month_pull_down(); ?>
            </select>
            月
            <select name="day">
                <?php days_pull_down(); ?>
            </select>
            日<br>
            <br>
            <input type="submit" value="ダウンロードへ">
        </form>
</body>
</html>