<?php
$dow =  date("w", strtotime($wl_d));
if (!empty($_GET['date'])) {
    $setd = TRUE;
} else {
    $setd = FALSE; 
}

if ($setd != TRUE and $dow <= 1 and $dow >= 5) {
    $show_day = "이번 주 시간표";
} elseif($setd != TRUE and $dow <= 7 and $dow >= 5) {
    $show_day = "다음 주 시간표";
} else {
    $show_day = "일주일 시간표";
}


// echo "<hr>";
?>

<?php
if ($dow == 1) {
    $start_day = date("Ymd", strtotime($wl_d." +0 days"));
    $end_day = date("Ymd", strtotime($wl_d." +4 days"));
    $sd1 = date("Ymd", strtotime($wl_d." +0 days"));
    $sd2 = date("Ymd", strtotime($wl_d." +1 days"));
    $sd3 = date("Ymd", strtotime($wl_d." +2 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +3 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +4 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 2) {
    $start_day = date("Ymd", strtotime($wl_d." -1 days"));
    $end_day = date("Ymd", strtotime($wl_d." +3 days"));
    $sd1 = date("Ymd", strtotime($wl_d." -1 days"));
    $sd2 = date("Ymd", strtotime($wl_d." +0 days"));
    $sd3 = date("Ymd", strtotime($wl_d." +1 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +2 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +3 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 3) {
    $start_day = date("Ymd", strtotime($wl_d." -2 days"));
    $end_day = date("Ymd", strtotime($wl_d." +2 days"));
    $sd1 = date("Ymd", strtotime($wl_d." -2 days"));
    $sd2 = date("Ymd", strtotime($wl_d." -1 days"));
    $sd3 = date("Ymd", strtotime($wl_d." +0 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +1 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +2 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 4) {
    $start_day = date("Ymd", strtotime($wl_d." -3 days"));
    $end_day = date("Ymd", strtotime($wl_d." +1 days"));
    $sd1 = date("Ymd", strtotime($wl_d." -3 days"));
    $sd2 = date("Ymd", strtotime($wl_d." -2 days"));
    $sd3 = date("Ymd", strtotime($wl_d." -1 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +0 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +1 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 5) {
    $start_day = date("Ymd", strtotime($wl_d." -4 days"));
    $end_day = date("Ymd", strtotime($wl_d." +0 days"));
    $sd1 = date("Ymd", strtotime($wl_d." -4 days"));
    $sd2 = date("Ymd", strtotime($wl_d." -3 days"));
    $sd3 = date("Ymd", strtotime($wl_d." -2 days"));
    $sd4 = date("Ymd", strtotime($wl_d." -1 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +0 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 6) {
    $start_day = date("Ymd", strtotime($wl_d." +2 days"));
    $end_day = date("Ymd", strtotime($wl_d." +6 days"));
    $sd1 = date("Ymd", strtotime($wl_d." +2 days"));
    $sd2 = date("Ymd", strtotime($wl_d." +3 days"));
    $sd3 = date("Ymd", strtotime($wl_d." +4 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +5 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +6 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
} elseif ($dow == 0) {
    $start_day = date("Ymd", strtotime($wl_d."+1 days"));
    $end_day = date("Ymd", strtotime($wl_d." +5 days"));
    $sd1 = date("Ymd", strtotime($wl_d." +1 days"));
    $sd2 = date("Ymd", strtotime($wl_d." +2 days"));
    $sd3 = date("Ymd", strtotime($wl_d." +3 days"));
    $sd4 = date("Ymd", strtotime($wl_d." +4 days"));
    $sd5 = date("Ymd", strtotime($wl_d." +5 days"));
    $sd = array($sd1,$sd2,$sd3,$sd4,$sd5);
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

if (empty($_GET["class"])) {
    $class = "1";
    $warring = TRUE;
    // echo $warring;
    // exit;
} else {
    $class = htmlspecialchars($_GET["class"]);
}

if ($kind == "high") {
    $histime_link = "https://open.neis.go.kr/hub/hisTimetable?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&TI_FROM_YMD=".$start_day."&TI_TO_YMD=".$end_day."&GRADE=".$grade."&CLRM_NM=".$class;
    $histime_json = file_get_contents($histime_link);
    $histime = json_decode($histime_json, TRUE);
    if ($histime_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        echo "<!--시간표 정보가 없습니다 일주일 시간표를 표시하지 않습니다 -->";
    } else {
        echo "<div class='box wow bounceIn'>";
        // echo "<h3>🕓 ".$show_day."</h3>";
        echo "<br>";
        echo '<table class="t_table">
        <th>　</th>
        <th>월</th>
        <th>화</th>
        <th>수</th>
        <th>목</th>
        <th>금</th>';
        $histime_row = $histime["hisTimetable"][1]["row"];
        $sa0 = array();
        $sa1 = array();
        $sa2 = array();
        $sa3 = array();
        $sa4 = array();
        foreach ($sd as $sd_row) {
            foreach ($histime_row as $row) {
                if ($row['ALL_TI_YMD'] == $sd_row) {
                    $seq = array_search($sd_row, $sd);
                    array_push(${"sa".$seq}, $row['ITRT_CNTNT']);
                }
            }
        }
        $cound_m = max(count($sa0), count($sa1), count($sa2), count($sa3), count($sa4)) - 1;
        foreach (range(0, $cound_m) as $i) {
            echo "<tr>\n";
            echo "<td>";
            $si = $i + 1;
            echo $si."교시";
            echo "</td>";
            for($c = 0; $c <=4; $c ++) {
                echo "<td>";
                if (empty(${"sa".$c}[$i])) {
                    echo "";
                } else {
                    echo ${"sa".$c}[$i];
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo '</table>';
        echo "</div>";
    }
} elseif ($kind == "middle") {
    $histime_link = "https://open.neis.go.kr/hub/misTimetable?KEY=2c6fbc2a7d3c4252a08a844a37703555&Type=json&ATPT_OFCDC_SC_CODE=".$office."&SD_SCHUL_CODE=".$his."&TI_FROM_YMD=".$wl_d."&TI_TO_YMD=".$wl_d."&GRADE=".$grade."&CLASS_NM=".$class;
    $histime_json = file_get_contents($histime_link);
    $histime = json_decode($histime_json, TRUE);
    if ($histime_json == '{"RESULT":{"CODE":"INFO-200","MESSAGE":"해당하는 데이터가 없습니다."}}') {
        echo "<!--시간표 정보가 없습니다 일주일 시간표를 표시하지 않습니다-->";
    } else {
        echo "<div class='box wow bounceIn'>";
        // echo "<h3>🕓 ".$show_day."</h3>";
        echo "<br>";
        echo '<table class="t_table">
        <th>　</th>
        <th>월</th>
        <th>화</th>
        <th>수</th>
        <th>목</th>
        <th>금</th>';
        $histime_row = $histime["misTimetable"][1]["row"];
        $sa0 = array();
        $sa1 = array();
        $sa2 = array();
        $sa3 = array();
        $sa4 = array();
        foreach ($sd as $sd_row) {
            foreach ($histime_row as $row) {
                if ($row['ALL_TI_YMD'] == $sd_row) {
                    $seq = array_search($sd_row, $sd);
                    array_push(${"sa".$seq}, $row['ITRT_CNTNT']);
                }
            }
        }
        $cound_m = max(count($sa0), count($sa1), count($sa2), count($sa3), count($sa4)) - 1;
        foreach (range(0, $cound_m) as $i) {
            echo "<tr>\n";
            echo "<td>";
            $si = $i + 1;
            echo $si."교시";
            echo "</td>";
            for($c = 0; $c <=4; $c ++) {
                echo "<td>";
                if (empty(${"sa".$c}[$i])) {
                    echo "";
                } else {
                    echo ${"sa".$c}[$i];
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    echo "</div>";
    }
    
}
?>

