<?php
if (empty($_GET["class"])) {
    header('Location: index.php');
    exit;
} else {
    $class = htmlspecialchars($_GET["class"]);
}


if (empty($_GET["grade"])) {
    header('Location: index.php');
    exit;
} else {
    $grade = htmlspecialchars($_GET["grade"]);
}

if (empty($_GET["kind"])) {
    header('Location: index.php');
    exit;
} else {
    $kind = htmlspecialchars($_GET["kind"]);
}


if (empty($_GET["his"])) {
    header('Location: index.php');
    exit;
} else {
    $his = htmlspecialchars($_GET["his"]);
}

if (empty($_GET["office"])) {
    header('Location: index.php');
    exit;
} else {
    $office = htmlspecialchars($_GET["office"]);
}

if (empty($_GET["saved"])) {
    $saved = FALSE;
} else {
    if ($_GET["saved"] == "1") {
        $saved = TRUE;
    } else {
        $saved = FALSE;
    }
}

if ($saved == TRUE) {

    setcookie('saved', '?class='.$class.'&grade='.$grade."&his=".$his."&office=".$office.'&kind='.$kind, time()+(86400*30), '/');
} else {
    if (!empty($_COOKIE["saved"])) {
        setcookie('saved', '', time()-3600, '/');
    }
    
}
echo "<meta http-equiv='refresh' content='0; url=main.php?class=".$class.'&grade='.$grade."&his=".$his."&office=".$office.'&kind='.$kind."'>";
?>