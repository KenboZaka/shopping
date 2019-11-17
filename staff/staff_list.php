<?php
session_start();
session_regenerate_id(true);

require_once('../config/dbconnect.php');
require_once('../config/functions.php');

if(isset($_SESSION['login'])==false){
    echo "ログインされていません";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a><br>';
    exit();
}
$staff_name = $_SESSION['staff_name'];

$sql = 'select * from mst_staff';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>staff all</title>
</head>
<body>
    <div class="container">
    <h5><?php echo $staff_name?>がログイン中です。</h5>
    <h3>スタッフ一覧</h3>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <tbody>
                        <?php foreach($staffs as $staff): ?>
                        <tr>
                            <td>
                            <form action="staff_edit/staff_edit.php" method="post" class="form-group">
                                <input type="radio" name="staffcode" value="<?php echo $staff['code']; ?>">
                                <a href="staff_each.php?code=<?php echo $staff['code']; ?>"><?php echo es($staff['name']); ?></a>
                                <input type="submit" class="form-control-sm" value="修正する">
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button onclick="location.href='staff_add/staff_add.php'" class="form-control" style="width:200px;">追加する</button>
            </div>
        </div>
    </div>
</body>
</html>