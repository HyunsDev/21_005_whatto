
<?php
require_once('src/moudle.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>내일뭐함 - 🗓️ 날짜 선택</title>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<?php


$warring = '<body>
<header>
    <div class="top">
        <h1>🎓 내일뭐함 🎓</h1>
    </div>
</header>
<div class="memubar">
</div>
<div class="box wow bounceIn">
<h3>올바르지 않은 접근</h3><hr>
<p>올바르지 않은 접근입니다.</p>
<a href="index.php">돌아가기</a>
</body>
</html>
';

date_default_timezone_set('Asia/Seoul');

if (empty($_GET["class"])) {
    echo $warring;
    exit;
}
$class = htmlspecialchars($_GET["class"]);

if (empty($_GET["grade"])) {
    echo $warring;
    exit;
}
$grade = htmlspecialchars($_GET["grade"]);

if (empty($_GET["his"])) {
    echo $warring;
    exit;
}
$his = htmlspecialchars($_GET["his"]);

if (empty($_GET["office"])) {
    echo $warring;
    exit;
}
$office = htmlspecialchars($_GET["office"]);

w_log();
?>


<body class="selclass ot">
<h1><img src="logo.png" class="main_logo" alt="로고"></h1><br>
    <label>날짜를 선택해주세요</label>
    
    <form action = "main.php" method = "get">
    <br>
        <input type="hidden" value="<?php echo $class ?>" name="class">
        <input type="hidden" value="<?php echo $grade ?>" name="grade">
        <input type="hidden" value="<?php echo $office ?>" name="office">
        <input type="hidden" value="<?php echo $his ?>" name="his">
        <input type="date" style="text-align: center" value="<?php echo date("Y-m-d") ?>" class="circlebutton" name="date"><br>
        <!-- <input type="date" style="width: auto; padding-left: 5px;" value="<?php echo date("Y-m-d") ?>" min="2020-03-02" max="2021-3-1" class="circlebutton" name="date"> -->
      <input type="submit" value="확인" class="circlebutton">

    </form>
</body>
</html>