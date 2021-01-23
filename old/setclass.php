<?php
require_once('src/moudle.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내일뭐함 - 학년/반 선택</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
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
</html>';

    if (empty($_GET["his"])) {
            echo $warring;
        exit;
    }
    if (empty($_GET["office"])) {
        echo $warring;
    exit;
}
    $his = htmlspecialchars($_GET["his"]);
    $office = htmlspecialchars($_GET["office"]);

    if (!empty($_GET["class"])) {
        if (!empty($_GET["grade"])) {
            header('Location: main.php?his='.$his."&grade=".htmlspecialchars($_GET["grade"])."&class=".htmlspecialchars($_GET["class"]));
        }
        
    }

    w_log();
?>

<body class="selclass ot">
    <h1><img src="logo.png" class="main_logo" alt="로고"></h1><br>
    <label>몇 학년 몇 반인가요?</label>
    <div class="selclassbutton">
        <div>
        <input type="button" id="scho" class="circlebutton selced" style="display:inline-block" value="<?php echo find_school($his); ?>" onclick="scho_check()">
        <input type="button" id="scho_ch" style="display:none" class="circlebutton selced" value="한 번 더 누르면 돌아갑니다" onclick="location.href='index.php'">
        <script>
            function scho_check() {
                
                document.getElementById("scho_ch").style.display = "inline-block";
                document.getElementById("scho").style.display = "none";
                
                setTimeout(function() {
                document.getElementById("scho").style.display = "inline-block";
                document.getElementById("scho_ch").style.display = "none";
                }, 2000);
            }
            </script>
        <br>
        <?php
            if (empty($_GET["grade"])) {
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 20px" class="circlebutton" value="1학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=1\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" class="circlebutton" value="2학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=2\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 20px" class="circlebutton" value="3학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=3\'">';
            } else {
                $setc1 = "";
                $setc2 = "";
                $setc3 = "";
                if ($_GET["grade"] == "1") {
                    $setc1 = " selced";
                } elseif ($_GET["grade"] == "2") {
                    $setc2 = " selced";
                } elseif ($_GET["grade"] == "3") {
                    $setc3 = " selced";
                }
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 20px" class="circlebutton'.$setc1.'" value="1학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=1\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" class="circlebutton'.$setc2.'" value="2학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=2\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 20px" class="circlebutton'.$setc3.'" value="3학년" onclick="location.href=\'setclass.php?office='.$office.'&his='.$his.'&grade=3\'">';
                
                $count = 0;
                echo "<br>";
                $class_num = (int)find_class($his, $_GET["grade"], $office);
                while(++$count <= $class_num){             // $count 값을 1증가시키고 12보다 작거나 같은지 확인한다.
                    echo '<input type="button" class="circlebutton" value="'.htmlspecialchars($_GET["grade"]).'학년 '.$count.'반" onclick="location.href=\'main.php?office='.$office.'&his='.$his.'&grade='.htmlspecialchars($_GET["grade"]).'&class='.$count.'\'"><br>';
               }

            

            }
        ?>
        </div>
        
    </div>

</body>
</html>