<?php
require_once('../src/moudle.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <title>내일뭐함 - 전국 학교 시간표, 급식표, 학사일정</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/animate.css">
    <script type="text/javascript" src="../js/all.min.js"></script>
    <script type="text/javascript" src="../js/wow.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
    $end_wl_d = date("Ymd",strtotime($wl_d." +7 days"));

    w_log(TRUE);
    $f_school = find_school($his);
?>


<body>
    <header>
        <div class="top" style="display:inline-block">
            <h1 class="main" style="margin-top: 0.9rem"><a onclick="history.back(-1);"><i class="fas fa-angle-left"></i> 일주일 급식</a></h1>
            <!-- <h2 class="set main">메뉴</h2> -->
        </div>
    </header>
    <section>
        <div style="margin-top:4rem"><div>
        <?php
            $meal_link = "https://open.neis.go.kr/hub/mealServiceDietInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&MLSV_FROM_YMD=".$wl_d."&MLSV_TO_YMD=".$end_wl_d;
            $meal_link_json = file_get_contents($meal_link);
            $meal = json_decode($meal_link_json, TRUE);
            
            if ($meal_link_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
                echo "급식 정보가 없습니다.. 방학중이라 그럴수도 있어요";
            } else {
                foreach ($meal["mealServiceDietInfo"][1]["row"] as $row) {
                    if (!empty($row["DDISH_NM"])) {
                        if ($row["MMEAL_SC_CODE"] == "1") {
                            $meal_code = " 아침";
                        } elseif ($row["MMEAL_SC_CODE"] == "3") {
                            $meal_code = " 저녁";
                        } else {
                            $meal_code = " 점심";
                        }
                        echo "<div class='box wow bounceIn'>";
                        echo "<h3>".date("m월 d일", strtotime($row["MLSV_YMD"])).$meal_code."</h3>";
                        echo "<p style='margin-top:0.5rem'>".$row["DDISH_NM"]."<br><span style='color: #999999; font-size: 0.9rem'>칼로리 : ".$row["CAL_INFO"]."</span>"."</p>";
                        // print_r($row);
                        echo "</div>";
                    }
                }
                
            }
            
        ?>

        <!-- <div class="box">
        <p><a href="javascript:window.location.reload(true);"><i class="fas fa-redo-alt"></i> 내일뭐함 새로고침 (디버그용)</a></p>
        </div> -->

    </section>
</body>
</html>