
<?php
$allview = file_get_contents("log/allview.log");
$allview = (int)$allview + 1;
$allview_file = fopen("log/allview.log", "w");
fwrite($allview_file, $allview);
fclose($allview_file);
$set_ = FALSE;
if (!empty($_GET["setting"])) {
    if ($_GET["setting"] == 1) {
        $set_ = TRUE;
    }
}

if (!empty($_COOKIE['saved'])) {
    if ($set_ != TRUE) {
        header('Location: main.php'.$_COOKIE['saved']);
        exit;
    }
}

function w_log() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
      }
    
      $http_host = $_SERVER['HTTP_HOST'];
      $request_uri = $_SERVER['REQUEST_URI'];
      $url_ = 'http://' . $http_host . $request_uri;

    $log_file = fopen("log/all.log", "a");
    $log_txt = "[ ".date("Y-m-d h:i:s")." ] WHERE : ".$url_." IP : ".$_SERVER["REMOTE_ADDR"]."\n";
    fwrite($log_file, $log_txt);
    fclose($log_file);
}

if (!empty($_GET["debug"])) {
    $debug = TRUE;
} else {
    $debug = FALSE;
}

function temp() {
    if (!empty($_GET["class"])) {
        if (!empty($_GET["grade"])) {
            return "&grade=".htmlspecialchars($_GET["grade"])."&class=".htmlspecialchars($_GET["class"]);
        }
    }
}

function find_school($office){
    global $debug;
    $url = "https://open.neis.go.kr/hub/schoolInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&pSize=500&Type=json&SCHUL_KND_SC_NM=".URLEncode("고등학교")."&ATPT_OFCDC_SC_CODE=".$office;
    $con = file_get_contents($url);
    $find = json_decode($con, TRUE);

    
    if ($con == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        echo "학교 정보가 없습니다";
    } else {
        foreach ($find["schoolInfo"][1]["row"] as $row) {
                echo '<input type="button" class="circlebutton" value="'.$row["SCHUL_NM"].'" onclick="location.href=\'class.php?office='.$office.'&his='.$row["SD_SCHUL_CODE"].temp().'\'"><br>'."\n";
        }
    }

}

w_log();

$office = file_get_contents("./src/school.json");
$office = json_decode($office, TRUE);
$office_id = $office["id"];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내일뭐함 - 학교선택</title>
    <link rel="stylesheet" type="text/css" href="./css/welcome.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158793073-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158793073-1');
</script>

</head>
<body>
    <h1><img src="logo_white.png" class="main_logo" alt="로고"></h1><br>
    <h2>Q1. 학교</h2><br>
    <label>당신이 다니는 학교는 어디인가요?<br>전국 모든 초/중/고 지원!</label></label>
    <div class="item">
        <form action="find_school.php">
            <?php
                if(!empty($_GET["setting"])){
                    echo '<input type="hidden" name="setting" value="1">';
                }
            ?>
            <input type="text" placeholder="학교를 검색하세요" class="searchbox" name="name"><br>
            <input type="submit" value="검색하기 🔍" class="circlebutton" style="text-align: center">
        </form>
            <div class="fill">
        </div>
        </div>
        
    </div>

</body>
</html>