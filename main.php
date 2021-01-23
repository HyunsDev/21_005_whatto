<?php
require_once('src/moudle.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="./css/animate.css">
    <script type="text/javascript" src="./js/all.min.js"></script>
    <script type="text/javascript" src="./js/js.js"></script>
    <script type="text/javascript" src="./js/wow.min.js"></script>
    <script> new WOW().init(); </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158793073-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-158793073-1');
    </script>

<?php
    $view = file_get_contents("log/view.log");
    $view = (int)$view + 1;
    $view_file = fopen("log/view.log", "w");
    fwrite($view_file, $view);
    fclose($view_file);

    $allview = file_get_contents("log/allview.log");
    $allview = (int)$allview + 1;
    $allview_file = fopen("log/allview.log", "w");
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

    if (empty($_GET["kind"])) {
        $warring = TRUE;
        $kind = "high";
        
        // echo $warring;
        // exit;
    } else {
        $kind = htmlspecialchars($_GET["kind"]);
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
        echo "4";
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
        $st = TRUE;
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
        if (date("H") >= 18) {
            if (date("N") < 5) {
                $wl_d = date("Ymd", strtotime($wl_d." +1 days"));
                $tw = " 내일 ";
            } elseif (date("N") == 5) {
                $wl_d = date("Ymd", strtotime($wl_d." +3 days"));
                $tw = " 글피 ";
            } elseif (date("N") == 6) {
                $wl_d = date("Ymd", strtotime($wl_d." +2 days"));
                $tw = " 모레 ";
            } else {
                $wl_d = date("Ymd", strtotime($wl_d." +1 days"));
                $tw = " 내일 ";
            }
        } else {
            if (date("N") == 0) {
                $wl_d = date("Ymd", strtotime($wl_d." +1 days"));
                $tw = " 내일 ";
            } elseif (date("N") <= 5) {
                $wl_d = date("Ymd", strtotime($wl_d." +0 days"));
                $tw = " 오늘 ";
            } elseif (date("N") == 6) {
                $wl_d = date("Ymd", strtotime($wl_d." +2 days"));
                $tw = " 모레 ";
            } else {
                $wl_d = date("Ymd", strtotime($wl_d." +0 days"));
                $tw = " 오늘 ";
            }
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

    function meal_fun($when){
        global $debug;
        global $wl_d;
        global $his;
        global $office;
        $meal_link = "https://open.neis.go.kr/hub/mealServiceDietInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&MLSV_FROM_YMD=".$wl_d."&MLSV_TO_YMD=".$wl_d;
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

    }

    function contents($content){
        global $wl_d;
        global $his;
        global $hisname;
        global $grade;
        global $kind;

        $list = scandir('./contents/'.$content."/");
        $i = 0;
        while($i < count($list)){
        if(($list[$i] != '.') and ($list[$i] != '..') and ($list[$i] != 'file')) {
            $con_str = file_get_contents("./contents/".$content."/".$list[$i]);
            $con = json_decode($con_str, TRUE);
            if ((in_array($his, $con["school"]) or in_array("all", $con["school"])) and ((in_array($grade, $con["grade"])) or (in_array("all", $con["grade"]))) and ($con["start_term"] <= $wl_d ) and ($con["end_term"] >= $wl_d) and (in_array($kind, $con["kind"]))) {
                if ($con["notitle"] != "true") {
                    if ($content == "notice") {
                        echo "<div class='box wow bounceIn'>";
                        echo "<h3>".$con["title"]."</h3>";
                        echo "<p class='label'>".$con["created"]." 등록 </p>";
                    } elseif ($content == "dday") {
                        echo "<div class='dday_box box wow bounceIn'>";
                    } elseif ($content == "content") {
                        echo "<div class='box wow bounceIn'>";
                        echo "<h3>".$con["title"]."</h3>";
                    }
                }
                $file = include("./contents/".$content."/file//".$con["id"].".php");
                if ($con["notitle"] != "true") {
                    echo "</div>";
                }
            }
        }
        $i = $i + 1;
    }
    }

        $s_info_url = "https://open.neis.go.kr/hub/schoolInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his;

        $s_info_url_json = file_get_contents($s_info_url);
        $s_info_reply = json_decode($s_info_url_json, TRUE);
        
        if ($s_info_reply == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
            echo "";
        } else {
            $s_info = $s_info_reply["schoolInfo"][1]["row"][0];
        }

    $f_school = find_school($his);
?>
<title><?php echo $f_school; ?> - 내일뭐함</title>
</head>
<body>
    <!-- 사이드 바 -->
    <nav>
    <div id="sidenav" class="sidenav">
        <div class="sidein">
            <input type="button" class="memu" value="<?php echo $m; ?>월 <?php echo $d; ?>일 <?php echo $dw; ?>요일" onclick="location.href='seldate.php?his=<?php echo $his ?>&grade=<?php echo $grade ?>&class=<?php echo $class ?>&office=<?php echo $office ?>&kind=<?php echo $kind ?>'">
            <input type="button" class="memu" value="<?php echo $f_school." ".$grade."학년 ".$class."반"; ?>" onclick="location.href='school.php?setting=1'">
            <input type="button" class="memu" value="급식정보" onclick="location.href='view/meal.php?<?php echo $_SERVER['QUERY_STRING']; ?>'">
        </div>
    </div>
        <script>
            function mopen() {
                document.getElementById("mopen_").style.display = "none";
                document.getElementById("mclose_").style.display = "inline-block";
                document.getElementById("sidenav").style.marginRight = "0";  
                document.getElementById("sidenav").style.marginLeft = "0";  
            }
            function mclose() {
                    document.getElementById("mopen_").style.display = "inline-block";
                    document.getElementById("mclose_").style.display = "none";
                    document.getElementById("sidenav").style.marginRight = "-70%";  
                    document.getElementById("sidenav").style.marginLeft = "70%";
            }
        </script>
    </nav>
    <!-- 사이드 바 -->

    <div id=all class="all">
    <!-- 탑 -->
    <header>
        <div class="top" style="display:inline-block">
            <h1 class="main" style="margin-top: 0.75rem; margin-left: 0.6rem"><i class="fas fa-school"></i> <?php echo $f_school; ?></h1>
            <h2 class="set main" id="mopen_" onclick="mopen()"><i class="fas fa-bars"></i></h2>
            <h2 class="set main" id="mclose_" style="display: None" onclick="mclose()"><i class="fas fa-bars"></i></h2>
        </div>
    </header>
    <!-- 탑 -->


    <!-- 본문 -->
    <section>
    <div class="action">
        <div class="action1 wow bounceIn" id="eatting_b" style="color: #FFFFFF;">
        급식정보
        </div>
        <div class="action2 wow bounceIn" id="date_b" style="color: #FFFFFF;">
            <?php echo $m; ?>월 <?php echo $d; ?>일 <?php echo $dw; ?>요일
        </div>
    </div>

    <script>
        $("#eatting_b").click(function(){
            location.href='view/meal.php?<?php echo $_SERVER["QUERY_STRING"]; ?>';
        });

        $("#date_b").click(function(){
            location.href='seldate.php?<?php echo $_SERVER["QUERY_STRING"]; ?>';
        });
    </script>

    <!-- <div class="memubar">
        <input type="button" class="memu wow bounceIn" value="<?php echo $m; ?>월 <?php echo $d; ?>일 <?php echo $dw; ?>요일" onclick="location.href='seldate.php?his=<?php echo $his ?>&grade=<?php echo $grade ?>&class=<?php echo $class ?>&office=<?php echo $office ?>&kind=<?php echo $kind ?>'">
    </div> -->

    <span style="line-height:3.5rem"><br></span>


   <!-- 내용 -->
    <?php contents("notice") ?>
    <?php contents("dday") ?>
    <?php 
        if ($warring == TRUE) {
            echo '<div class="dday_box box wow bounceIn"><p clsss="dday">앗 문제가 생겼어요<br><a href="index.php">돌아가기</a><p></div>';
        }
    ?>

    <?php
        if ($kind != "low") {
            echo '<div class="box wow bounceIn">';
            echo '<h3><i class="far fa-clipboard"></i> '.$tw.' 시간표</h3>';
            echo "<p>".histime_fun()."</p>";
            echo "</div>";
        }
    ?>

    <?php
        if ($kind == "high") {
            echo '<div class="cus box wow bounceIn" onclick="location.href=\'view/meal.php?'.$_SERVER["QUERY_STRING"].'\'">
            <h3><i class="fa fa-utensils"></i> '.$tw.'아침 메뉴</h3>';
            echo "<p>".meal_fun(0)."</p>";
            echo '</div>';

            echo '<div class="cus box wow bounceIn" onclick="location.href=\'view/meal.php?'.$_SERVER["QUERY_STRING"].'\'">
            <h3><i class="fa fa-utensils"></i> '.$tw.'점심 메뉴</h3>';
            echo "<p>".meal_fun(1)."</p>";
            echo '</div>';

            echo '<div class="cus box wow bounceIn" onclick="location.href=\'view/meal.php?'.$_SERVER["QUERY_STRING"].'\'">
            <h3><i class="fa fa-utensils"></i> '.$tw.'저녁 메뉴</h3>';
            echo "<p>".meal_fun(2)."</p>";
            echo "</div>";

        } else {
            echo '<div class="cus box wow bounceIn" onclick="location.href=\'view/meal.php?'.$_SERVER["QUERY_STRING"].'\'">
            <h3><i class="fa fa-utensils"></i> '.$tw.' 점심 메뉴</h3>';
            echo "<p>".meal_fun(0)."</p>";
            echo '</div>';
        }
    ?>

    <?php contents("content") ?>

    <!-- <div class="box wow bounceIn" id="disqus_thread"></div>
    <script>
    (function() {
    var d = document, s = d.createElement('script');
    s.src = 'https://whatto-kr.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript> -->
    

    <div class="box wow bounceIn">
        <h3><i class="fas fa-school"></i> 우리 학교 정보</h3>
        <p style="margin-top: 0">주소 : <?php echo $s_info["ORG_RDNMA"]; ?> <?php echo $s_info["ORG_RDNDA"]; ?><br>
        우편번호 : <?php echo $s_info["ORG_RDNZC"]; ?><br>
        영문 이름 : <?php echo $s_info["ENG_SCHUL_NM"]; ?><br>
        전화번호 : <?php echo $s_info["ORG_TELNO"]; ?><br>
        팩스 : <?php echo $s_info["ORG_FAXNO"]; ?><br>
        홈페이지 : <a href="<?php echo $s_info["HMPG_ADRES"]; ?>"><?php echo $s_info["HMPG_ADRES"]; ?></a><br>


        개교기념일 : <?php 
        if ($his == 7430148) {
            echo "2004년 3월 3일"; 
        } else {
            echo date("Y년 m월 d일",$s_info["FOAS_MEMRD"]); 
        }
        
        
        ?></p>


        <p><a href="school.php?setting=1">학교 수정하기</a></p>
    </div>
    </section>

    <footer>
    <div class="footer box wow bounceIn">
        <h3><i class="fas fa-info"></i> 내일뭐함 정보</h3>
        <p style="margin-top: 0"><i class="fas fa-male"></i> 만든 이 : 서령고등학교 1학년 박현우<br>
        <i class="fab fa-discord"></i> 디스코드 : <a href="https://discord.gg/5Gpywph">https://discord.gg/5Gpywph</a><br>
        <i class="far fa-envelope"></i> 메일 : whatto@hyuns.me<br>
        <i class="fas fa-server"></i> 내일뭐함 버전 : #210124</p>
        <p><a href='https://www.notion.so/9392ddc56c0f4ff6afeeccbba56e2708'><i class="fas fa-pen-nib"></i> 내일뭐함 실시간 업데이트 목록</a><br></p>
        <p><a href="javascript:window.location.reload(true);"><i class="fas fa-redo-alt"></i> 내일뭐함 새로고침</a></p>
    </div>
    </footer>
    </div>
</body>
</html>