<?php 

$allview = file_get_contents("log/allview.log");
$allview = (int)$allview + 1;
$allview_file = fopen("log/allview.log", "w");
fwrite($allview_file, $allview);
fclose($allview_file);
if (empty($_GET["name"])) {
    echo "<script>alert(\"검색어가 비어있어요..\");</script>";
    echo '<meta http-equiv="refresh" content="0; url=school.php">';
    exit;
}
$name = URLEncode($_GET["name"]);
$url = "https://open.neis.go.kr/hub/schoolInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&pSize=500&Type=json&SCHUL_NM=".$name;
$con = file_get_contents($url);
$find = json_decode($con, TRUE);
if ($con == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
    echo "<script>alert(\"학교를 찾을 수 없어요.. 정확하게 입력했나요?\");</script>";
    echo '<meta http-equiv="refresh" content="0; url=school.php">';
    exit;
}

if(!empty($_GET["setting"])){
    $setting = "&setting=1";
} else {
    $setting = "";
}



if ($find["schoolInfo"][0]["head"][0]["list_total_count"] == 1) {
    if ($find["schoolInfo"][1]["row"][0]["SCHUL_KND_SC_NM"] == "고등학교") {
        header("location: class.php?office=".$find["schoolInfo"][1]["row"][0]["ATPT_OFCDC_SC_CODE"]."&kind=high&save=True&his=".$find["schoolInfo"][1]["row"][0]["SD_SCHUL_CODE"].$setting);
        exit;
    } elseif ($find["schoolInfo"][1]["row"][0]["SCHUL_KND_SC_NM"] == "중학교") {
        header("location: class.php?office=".$find["schoolInfo"][1]["row"][0]["ATPT_OFCDC_SC_CODE"]."&kind=middle&save=True&his=".$find["schoolInfo"][1]["row"][0]["SD_SCHUL_CODE"].$setting);
        exit;   
    } elseif ($find["schoolInfo"][1]["row"][0]["SCHUL_KND_SC_NM"] == "초등학교") {
        header("location: class.php?office=".$find["schoolInfo"][1]["row"][0]["ATPT_OFCDC_SC_CODE"]."&kind=low&save=True&his=".$find["schoolInfo"][1]["row"][0]["SD_SCHUL_CODE"].$setting);
        exit;
    } else {
        echo "<script>alert(\"아쉽게도 초등학교, 중학교, 고등학교외의 학교는 지원하지 않아요...\");</script>";
        echo '<meta http-equiv="refresh" content="0; url=school.php">';
        exit;
    }
    
}

function temp() {
    if (!empty($_GET["class"])) {
        if (!empty($_GET["grade"])) {
            return "&grade=".$_GET["grade"]."&class=".$_GET["class"];
        }
    }
}

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
    <div class="item_all item">
        <p>검색결과가 여러개가 나왔어요</p>
        <p>이중에서 어느 학교를 다니시나요?</p><br>
        <?php
            echo '<input type="button" class="circlebutton selced" value="돌아가기" onclick="location.href=\'index.php\'"><br>'."\n";
            foreach ($find["schoolInfo"][1]["row"] as $row) {
                if ($row["SCHUL_KND_SC_NM"] == "고등학교") {
                    $kind = "&kind=high";
                    echo '<input type="button" style=" padding: 0px 20px 0px 20px" class="long" value="[ '.$row["JU_ORG_NM"]." ] ".$row["SCHUL_NM"].'" onclick="location.href=\'class.php?office='.$row["ATPT_OFCDC_SC_CODE"].$kind."&his=".$row["SD_SCHUL_CODE"].temp().$setting.'&save=True\'"><br>'."\n";
                } elseif ($row["SCHUL_KND_SC_NM"] == "중학교") {
                    $kind = "&kind=middle";
                    echo '<input type="button" style=" padding: 0px 20px 0px 20px" class="long" value="[ '.$row["JU_ORG_NM"]." ] ".$row["SCHUL_NM"].'" onclick="location.href=\'class.php?office='.$row["ATPT_OFCDC_SC_CODE"].$kind."&his=".$row["SD_SCHUL_CODE"].temp().$setting.'&save=True\'"><br>'."\n";
                } elseif ($row["SCHUL_KND_SC_NM"] == "초등학교") {
                    $kind = "&kind=low";
                    echo '<input type="button" style=" padding: 0px 20px 0px 20px" class="long" value="[ '.$row["JU_ORG_NM"]." ] ".$row["SCHUL_NM"].'" onclick="location.href=\'class.php?office='.$row["ATPT_OFCDC_SC_CODE"].$kind."&his=".$row["SD_SCHUL_CODE"].temp().$setting.'&save=True\'"><br>'."\n";
                }
            }
            
        ?>

    </div>

</body>
</html>