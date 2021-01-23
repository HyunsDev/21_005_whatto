<?php
require_once('src/moudle.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내일뭐함 - 고등학교 시간표, 급식표, 학사일정</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="./css/animate.css">
    <script type="text/javascript" src="./js/wow.min.js"></script>
    <script> new WOW().init(); </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <script data-ad-client="ca-pub-9458548308168502" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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

$warring = FALSE;

if (empty($_GET["class"])) {
    $class = "1";
    $warring = TRUE;
    // echo $warring;
    // exit;
} else {
    $class = htmlspecialchars($_GET["class"]);
}


if (empty($_GET["grade"])) {
    $warring = TRUE;
    $grade = "1";
    // echo $warring;
    // exit;
} else {
    $grade = htmlspecialchars($_GET["grade"]);
}


if (empty($_GET["his"])) {
    $warring = TRUE;
    $his = "8140089";
    // echo $warring;
    // exit;
} else {
    $his = htmlspecialchars($_GET["his"]);
}

if (empty($_GET["office"])) {
    $warring = TRUE;
    $office = "N10";
    // echo $warring;
    // exit;
} else {
    $office = htmlspecialchars($_GET["office"]);
}



$hisname = file_get_contents("./src/school.json");
$hisname = json_decode($hisname, TRUE);
$hisid = $hisname["id"];
$temp = "?grade=".$grade."&class=".$class;


date_default_timezone_set('Asia/Seoul');
$week_N = array('','월','화','수','목','금','토', "일");


if (!empty($_GET['date'])) {
    $day = htmlspecialchars($_GET['date']);
    $tw = "";
    $dw = $week_N[date("N", strtotime($day))];
    $m = date("n", strtotime($day));
    $d = date("j", strtotime($day));
    $wl_d = date("Ymd", strtotime($day));
    
} else {
    $dw = $week_N[date("N")];
    $wl_d = date("Ymd");
    $st = FALSE;
    if (date("N") < 5) {
        $tw = " 내일 ";
    } elseif (date("N") == 5) {
        $tw = " 글피 ";
    } elseif (date("N") == 6) {
        $tw = " 모레 ";
    } else {
        $tw = " 내일 ";
    }
    $m = date("n");
    $d = date("j");
}

w_log();

function histime_fun(){
    global $debug;
    global $wl_d;
    global $class;
    global $grade;
    global $his;
    $histime_link = "https://open.neis.go.kr/hub/hisTimetable?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=N10&SD_SCHUL_CODE=".$his."&TI_FROM_YMD=".$wl_d."&TI_TO_YMD=".$wl_d."&GRADE=".$grade."&CLRM_NM=".$class;
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

    if ($debug) {
        echo "<br>".$histime_link;
    }
}

function meal_fun($when){
    global $debug;
    global $wl_d;
    global $his;
    $meal_link = "https://open.neis.go.kr/hub/mealServiceDietInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=N10&SD_SCHUL_CODE=".$his."&MLSV_FROM_YMD=".$wl_d."&MLSV_TO_YMD=".$wl_d;
    $meal_link_json = file_get_contents($meal_link);
    $meal = json_decode($meal_link_json, TRUE);
    
    if ($meal_link_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        echo "급식 정보가 없습니다";
    } else {
        $meal_link_row = $meal["mealServiceDietInfo"][1]["row"];
        if (empty($meal_link_row[$when]["DDISH_NM"])) {
            echo "급식 정보가 없습니다";
        } else {
        echo $meal_link_row[$when]["DDISH_NM"];
    }
    }

    if ($debug) {
        echo "<br>".$meal_link;
    }

}

function notice(){
    global $wl_d;
    global $his;
    global $hisname;
    global $debug;
    global $grade;

    $list = scandir('./notice');
    $i = 0;
    while($i < count($list)){
    if($list[$i] != '.') {
        if($list[$i] != '..') {
            if($list[$i] != 'not use') {
                $con_str = file_get_contents("./notice/".$list[$i]);
                $con = json_decode($con_str, TRUE);
                foreach ($con["school"] as $sch) {
                    if ($sch == $his) {
                        foreach ($con["grade"] as $gra) {
                            if ($grade == $gra) {
                                echo "<div class='box wow bounceIn'>";
                                echo $con["contents"];
                                echo "</div>";
                            }
                        }
                    } elseif ($sch == "all") {
                        foreach ($con["grade"] as $gra) {
                            if ($grade == $gra) {
                                echo "<div class='box wow bounceIn'>";
                                echo $con["contents"];
                                echo "</div>";
                            }
                        }
                    }
                }
            }
        }
    }
    $i = $i + 1;
  }
}
?>


<body>
    <header>
        <div class="top" style="display:inline-block">
            <img src="logo_white.png" alt="로고">
            <h1>내일뭐함</h1>
        </div>
    </header>

    <section>
        
    <div class="memubar">
        <input type="button" class="memu wow bounceIn" value="<?php echo find_school($his)." ".$grade."학년 ".$class."반"; ?>" onclick="location.href='index.php<?php echo $temp; ?>'">
        <input type="button" class="memu wow bounceIn" value="<?php echo $m; ?>월 <?php echo $d; ?>일 <?php echo $dw; ?>요일" onclick="location.href='seldate.php?his=<?php echo $his ?>&grade=<?php echo $grade ?>&class=<?php echo $class ?>&office=<?php echo $office ?>'">
    </div>
    <?php notice() ?>

    <div class="box wow bounceIn">
        <p class="dday">개학 <b>
        <?php
            $date = "2020-03-01"; // 2013-07-14 09:14:00  
            $todate = $wl_d;
            
            $ddy = (strtotime($todate) - strtotime($date)) / 86400;  

            echo "D".$ddy;
        ?>
        </b></p>
    </div>

    <?php 
    if ($warring == TRUE) {
        echo '<div class="box wow bounceIn"><p clsss="dday">앗 문제가 생겼어요<br><a href="index.php">돌아가기</a><p></div>';
    }

    ?>

    <div class="box wow bounceIn">
        <h3>🕓<?php echo $tw ?> 시간표</h3><hr>
        
        
        <?php histime_fun() ?>
    </div>

    <div class="box wow bounceIn">
        <h3>🥪<?php echo $tw ?> 아침 메뉴</h3><hr>
        <?php meal_fun(0) ?>
    </div>

    <div class="box wow bounceIn">
        <h3>🍲<?php echo $tw ?> 점심 메뉴</h3><hr>
        <?php meal_fun(1) ?>
    </div>

    <div class="box wow bounceIn">
        <h3>🍖<?php echo $tw ?> 저녁 메뉴</h3><hr>
        <?php meal_fun(2) ?>
    </div>

    </section>
    
    <footer>
    <div class="footer box wow bounceIn">
        <h3>👨‍🎓 내일뭐함 정보</h3><hr>
        만든 이 : 서령고등학교 예비 1학년 박현우<br>
        공식 디스코드 서버 : <a href="https://discord.gg/5Gpywph">https://discord.gg/5Gpywph</a><br>
        메일 : hyuns@hyuns.space<br>
        <a href='update.php?his=<?php echo $his ?>&grade=<?php echo $grade ?>&class=<?php echo $class ?>&office=<?php echo $office ?>'>내일뭐함 실시간 업데이트 목록</a>
    </div>
    </footer>
</body>
</html>