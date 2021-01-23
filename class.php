<?php
require_once('src/moudle.php');

$allview = file_get_contents("log/allview.log");
$allview = (int)$allview + 1;
$allview_file = fopen("log/allview.log", "w");
fwrite($allview_file, $allview);
fclose($allview_file);
?>

<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내일뭐함 - 학년/반 선택</title>
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
</html>';

    if (empty($_GET["his"])) {
            echo $warring;
        exit;
    }
    if (empty($_GET["office"])) {
        echo $warring;
    exit;
    }
    if (empty($_GET["kind"])) {
        echo $warring;
    exit;
    }

    $kind = htmlspecialchars($_GET["kind"]);
    $his = htmlspecialchars($_GET["his"]);
    $office = htmlspecialchars($_GET["office"]);

    if (!empty($_GET["class"])) {
        if (!empty($_GET["grade"])) {
            header('Location: main.php?his='.$his."&grade=".htmlspecialchars($_GET["grade"])."&class=".htmlspecialchars($_GET["class"]));
        }
        
    }

    w_log();
?>

<body>
    <h1><img src="logo_white.png" class="main_logo" alt="로고"></h1><br>
    <h2>Q2. 학년/반</h2><br>
    <label>몇 학년 몇 반인가요?</label>
    <?php
    if (empty($_GET["grade"])) {
        echo "\n".'<div class="item">';
    } else {
        echo "\n<br><br><br>";
        echo '<div class="item_all item">';
    }
    ?>
        
        <?php
        $http_host = $_SERVER['HTTP_HOST'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $gd = "";
        if (!empty($_GET["grade"])) {
            $gd = "&grade=".htmlspecialchars($_GET["grade"]);
        }

        $saved = FALSE;
        if (!empty($_GET["save"])) {
            if ($_GET["save"] == "True") {
                $saved = TRUE;
            }
        }

        if ($saved) {
                echo '<input type="button" class=" selced" value="학교&반 선택 기억하기 ✔️" onclick="location.href=\'class.php?his='.$his."&kind=".$kind."&office=".$office.$gd.'\'"><br>';
        } else {
            echo '<input type="button" class="" value="학교&반 선택 기억하기 ❌" onclick="location.href=\'class.php?his='.$his."&kind=".$kind."&office=".$office."&save=True".'\'"><br>';
        }
        ?>
        
        <input type="button" id="scho" class="butt selced" style="display:inline-block" value="🏫 <?php echo find_school($his); ?> 🏫" onclick="scho_check()">
        <input type="button" id="scho_ch" style="display:none" class="butt selced" value="한 번 더 누르면 돌아갑니다" onclick="location.href='school.php'">
        <script>
            function scho_check() {
                
                document.getElementById("scho_ch").style.display = "inline-block";
                document.getElementById("scho").style.display = "none";
                
                setTimeout(function() {
                document.getElementById("scho").style.display = "inline-block";
                document.getElementById("scho_ch").style.display = "none";
                }, 2000);
            }
            </script>
        <br>
        <?php


        if ($saved) {
            $ss = "&save=True";
        } else {
            $ss = "";
        }
            if (empty($_GET["grade"])) {
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 15px"value="1학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=1\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" value="2학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=2\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 15px" value="3학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=3\'">';
                if ($kind == "low") {
                    echo "<br>";
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 15px"value="4학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=4\'">';
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" value="5학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=5\'">';
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 15px" value="6학년" onclick="location.href=\'class.php?office='.$office.'&his='.$his.$ss."&kind=".$kind.'&grade=6\'">';
                }
            } else {
                $setc1 = "";
                $setc2 = "";
                $setc3 = "";
                $setc4 = "";
                $setc5 = "";
                $setc6 = "";
                $setg1= "";
                $setg2= "";
                $setg3= "";
                $setg4= "";
                $setg5= "";
                $setg6= "";
                if ($_GET["grade"] == "1") {
                    $setc1 = " selced";
                    $setg2= "&grade=2";
                    $setg3= "&grade=3";
                    if ($kind == "low") {
                        $setg4= "&grade=4";
                        $setg5= "&grade=5";
                        $setg6= "&grade=6";
                    }
                } elseif ($_GET["grade"] == "2") {
                    $setc2 = " selced";
                    $setg1= "&grade=1";
                    $setg3= "&grade=3";
                    if ($kind == "low") {
                        $setg4= "&grade=4";
                        $setg5= "&grade=5";
                        $setg6= "&grade=6";
                    }
                } elseif ($_GET["grade"] == "3") {
                    $setc3 = " selced";
                    $setg1= "&grade=1";
                    $setg2= "&grade=2";
                    if ($kind == "low") {
                        $setg4= "&grade=4";
                        $setg5= "&grade=5";
                        $setg6= "&grade=6";
                    }
                } elseif ($_GET["grade"] == "4") {
                    $setg1= "&grade=1";
                    $setg2= "&grade=2";
                    $setg3 = "&grade=3";
                    $setc4= " selced";
                    $setg5= "&grade=5";
                    $setg6= "&grade=6";
                } elseif ($_GET["grade"] == "5") {
                    $setg1= "&grade=1";
                    $setg2= "&grade=2";
                    $setg3 = "&grade=3";
                    $setg4= "&grade=4";
                    $setc5= " selced";
                    $setg6= "&grade=6";
                } elseif ($_GET["grade"] == "6") {
                    $setg1= "&grade=1";
                    $setg2= "&grade=2";
                    $setg3 = "&grade=3";
                    $setg4= "&grade=4";
                    $setg5= "&grade=5";
                    $setc6= " selced";
                } 

                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 15px" class="'.$setc1.'" value="1학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg1.'\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" class="'.$setc2.'" value="2학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg2.'\'">';
                echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 15px" class="'.$setc3.'" value="3학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg3.'\'">';
                if ($kind == "low") {
                    echo "<br>";
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-right: 15px" class="'.$setc4.'" value="4학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg4.'\'">';
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px" class="'.$setc5.'" value="5학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg5.'\'">';
                    echo '<input type="button" style="width: auto; padding: 0px 20px 0px 20px; margin-left: 15px" class="'.$setc6.'" value="6학년" onclick="location.href=\'class.php?office='.$office."&kind=".$kind.'&his='.$his.$ss.$setg6.'\'">';
                    
                }
                $count = 0;
                echo "<br>";
                $class_num = (int)find_class($his, $_GET["grade"], $office);

        
                if ($saved) {
                    $saving = "1";
                } else {
                    $saving = "0";
                }
				
				if ($class_num == 0) {
                    $class_num == $class_num + 1;
					echo "<form action='cookie.php' method='GET'>";
					echo '<input type="hidden" name="grade" value='.htmlspecialchars($_GET["grade"]).'>';
					echo '<input type="hidden" name="his" value='.$his.'>';
                    echo '<input type="hidden" name="office" value='.$office.'>';
                    echo '<input type="hidden" name="saved" value='.$saving.'>';
                    echo '<input type="hidden" name="kind" value='.$kind.'>';
					
					echo '<input type="number" name="class" style="text-align: center; width: 230px;" placeholder="몇 반이신가요?" min="0"> 반<br>';
					echo '<input type="submit" value="확인" style="text-align: center">';
					echo "</form>";
				} else {
					while(++$count <= $class_num){             // $count 값을 1증가시키고 12보다 작거나 같은지 확인한다.
                    echo '<input type="button" value="'.htmlspecialchars($_GET["grade"]).'학년 '.$count.'반" onclick="location.href=\'cookie.php?office='.$office.'&his='.$his.'&grade='.htmlspecialchars($_GET["grade"])."&kind=".$kind.'&class='.$count."&saved=".$saving.'\'"><br>';
               }
				}
            

            }
        ?>
        </div>
        
    </div>

</body>
</html>