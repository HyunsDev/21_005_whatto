<?php
function find_school($id){
    $url = "https://open.neis.go.kr/hub/schoolInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&pSize=500&Type=json&SD_SCHUL_CODE=".$id;
    $con = file_get_contents($url);
    $find = json_decode($con, TRUE);

    if ($con == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        return "학교 정보가 없습니다";
    } else {
        return $find["schoolInfo"][1]["row"][0]["SCHUL_NM"];
    }
}

function get_time() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


function find_class($id, $grade, $office){
    $url = "https://open.neis.go.kr/hub/classInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&pSize=100&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$id."&GRADE=".$grade;

    $con = file_get_contents($url); 

    $find = json_decode($con, TRUE);

    if ($con == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        return "학교 정보가 없습니다";
    } else {
       $re = $find["classInfo"][0]["head"][0]["list_total_count"];
       return $re;
    }
}

function w_log($out=FALSE) {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
      }
    
      $http_host = $_SERVER['HTTP_HOST'];
      $request_uri = $_SERVER['REQUEST_URI'];
      $url_ = 'http://' . $http_host . $request_uri;
    if ($out==FALSE) {
        $log_file = fopen("log/all.log", "a");
    } elseif ($out==TRUE) {
        $log_file = fopen("../log/all.log", "a");
    }
    
    $log_txt = "[ ".date("Y-m-d h:i:s")." ] WHERE : ".$url_." IP : ".$_SERVER["REMOTE_ADDR"]."\n";
    fwrite($log_file, $log_txt);
    fclose($log_file);
}

$set_ = FALSE;
function find_cookie() {
    if (!empty($_GET["setting"])) {
        if ($_GET["setting"] == 1) {
            $set_ = TRUE;
        }
    }

    if (!empty($_COOKIE['saved'])) {
        if ($set_ != TRUE) {
            header('Location: main.php'.htmlspecialchars($_COOKIE['saved']));
        exit;
        }
        
    }
}

?>

