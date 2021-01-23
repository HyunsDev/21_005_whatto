<?php
require_once('../src/moudle.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내일뭐함 - 전국 학교 시간표, 급식표, 학사일정</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/animate.css">
    <script type="text/javascript" src="../js/wow.min.js"></script>
    <script type="text/javascript" src="../js/js.js"></script>
    <script> new WOW().init(); </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../favicon.ico">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158793073-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-158793073-1');
    </script>

</head>
<?php

    $allview = file_get_contents("../log/allview.log");
    $allview = (int)$allview + 1;
    $allview_file = fopen("../log/allview.log", "w");
    fwrite($allview_file, $allview);
    fclose($allview_file);


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

    $warring = FALSE;

    if (empty($_GET["class"])) {
        echo $warring;
        exit;
    } else {
        $class = htmlspecialchars($_GET["class"]);
    }


    if (empty($_GET["grade"])) {
        echo $warring;
        exit;
    } else {
        $grade = htmlspecialchars($_GET["grade"]);
    }

    if (empty($_GET["kind"])) {
        echo $warring;
        exit;
    } else {
        $kind = htmlspecialchars($_GET["kind"]);
    }


    if (empty($_GET["his"])) {
        echo $warring;
        exit;
    } else {
        $his = htmlspecialchars($_GET["his"]);
    }

    if (empty($_GET["office"])) {
        echo $warring;
        exit;
    } else {
        $office = htmlspecialchars($_GET["office"]);
    }

    $hisname = file_get_contents("../src/school.json");
    $hisname = json_decode($hisname, TRUE);
    $hisid = $hisname["id"];
    $temp = "?grade=".$grade."&class=".$class;


    date_default_timezone_set('Asia/Seoul');

    $wl_d = date("Ymd");


    w_log();

    function histime_fun(){
        global $debug;
        global $wl_d;
        global $class;
        global $grade;
        global $his;
        global $kind;
        global $office;
        if ($kind == "high") {
            $histime_link = "https://open.neis.go.kr/hub/hisTimetable?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&TI_FROM_YMD=".$wl_d."&TI_TO_YMD=".$wl_d."&GRADE=".$grade."&CLRM_NM=".$class;
            $histime_json = file_get_contents($histime_link);
            $histime = json_decode($histime_json, TRUE);
            if ($histime_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
                echo "시간표 정보가 없습니다";
            } else {
                echo "<ol>";
                $histime_row = $histime["hisTimetable"][1]["row"];
                foreach ($histime_row as $row) {
                    echo "<li class='li'>".$row['ITRT_CNTNT']."</li>";
                }
                echo "</ol>";
            }
        } elseif ($kind == "middle") {
            $histime_link = "https://open.neis.go.kr/hub/misTimetable?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&TI_FROM_YMD=".$wl_d."&TI_TO_YMD=".$wl_d."&GRADE=".$grade."&CLASS_NM=".$class;
            $histime_json = file_get_contents($histime_link);
            $histime = json_decode($histime_json, TRUE);
            if ($histime_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
                echo "시간표 정보가 없습니다";
            } else {
                echo "<ol>";
                $histime_row = $histime["misTimetable"][1]["row"];
                foreach ($histime_row as $row) {
                    echo "<li class='li'>".$row['ITRT_CNTNT']."</li>";
                }
                echo "</ol>";
            }
        }
    }
    $f_school = find_school($his);
?>


<body>
    <header>
        <div class="top" style="display:inline-block">
            <img src="../logo_white.png" alt="로고">
            <h1 class="main"><?php echo $f_school; ?></h1>
            <h2 class="set main">메뉴</h2>
        </div>
    </header>
    <section>

    </section>
</body>
</html>