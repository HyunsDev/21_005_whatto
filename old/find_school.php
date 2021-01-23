<?php 
if (empty($_GET["name"])) {
    echo "<script>alert(\"검색어가 비어있어요..\");</script>";
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    exit;
}
$name = URLEncode($_GET["name"]);
$url = "https://open.neis.go.kr/hub/schoolInfo?KEY=2c6fbc2a7d3c4252a08a844a37703555&pSize=500&Type=json&SCHUL_KND_SC_NM=".URLEncode("고등학교")."&SCHUL_NM=".$name;
$con = file_get_contents($url);
$find = json_decode($con, TRUE);
if ($con == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
    echo "<script>alert(\"학교를 찾을 수 없어요.. 정확하게 입력했나요?\");</script>";
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    exit;
} 

if ($find["schoolInfo"][0]["head"][0]["list_total_count"] == 1) {
    header("location: setclass.php?office=".$find["schoolInfo"][1]["row"][0]["ATPT_OFCDC_SC_CODE"]."&his=".$find["schoolInfo"][1]["row"][0]["SD_SCHUL_CODE"]);
    exit;
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
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <script data-ad-client="ca-pub-9458548308168502" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body class="selclass ot">
    <h1 style="font-size: 50px;">🎓 내일뭐함 🎓</h1><br>
    <label>고등학교 내일예보</label>
    <div class="selclassbutton">
        <p>학교를 선택해주세요</p>
        <?php
            echo '<input type="button" class="circlebutton selced" value="돌아가기" onclick="location.href=\'index.php\'"><br>'."\n";
            foreach ($find["schoolInfo"][1]["row"] as $row) {
                echo '<input type="button" style="width: 400px; padding: 0px 20px 0px 20px" class="circlebutton" value="[ '.$row["JU_ORG_NM"]." ] ".$row["SCHUL_NM"].'" onclick="location.href=\'setclass.php?office='.$row["ATPT_OFCDC_SC_CODE"]."&his=".$row["SD_SCHUL_CODE"].temp().'\'"><br>'."\n";
            }
            
        ?>

    </div>

</body>
</html>