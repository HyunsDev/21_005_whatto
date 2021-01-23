
<?php
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
                echo '<input type="button" class="circlebutton" value="'.$row["SCHUL_NM"].'" onclick="location.href=\'setclass.php?office='.$office.'&his='.$row["SD_SCHUL_CODE"].temp().'\'"><br>'."\n";
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
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body class="selclass ot">
    <h1><img src="logo.png" class="main_logo" alt="로고"></h1><br>
    <label>어디 고등학교를 다니시나요?</label>
    <div class="selclassbutton">
        <form action="find_school.php">
            <input type="text" placeholder="학교를 검색하세요" class="searchbox" name="name"><br>
            <input type="submit" value="검색하기" class="circlebutton" style="text-align: center">
        </form>
        <br>
        <div>
            <?php 
                if (!empty($_GET["office"])) {
                    if (($_GET["office"]) == "search") {
                        echo '<input type="button" class="circlebutton selced" value="학교 목록 닫기" onclick="location.href=\'index.php\'"><br>'."\n";
                        foreach ($office_id as $row) {   
                            echo '<input type="button" class="circlebutton" value="'.$office[$row].'교육청" onclick="location.href=\'index.php?office='.$row.temp().'\'"><br>'."\n";
                        
                        }
                    } else {
                        echo '<input type="button" class="circlebutton selced" value="'.$office[$_GET["office"]].'교육청" onclick="location.href=\'index.php?office=search'.temp().'\'"><br>'."\n";
                        find_school($_GET["office"]);
                    }
                    
                } else {
                    echo '<input type="button" class="circlebutton" value="학교 목록 열기" onclick="location.href=\'index.php?office=search'.temp().'\'"><br>'."\n";
                }
            ?>
        </div>
        
    </div>

</body>
</html>