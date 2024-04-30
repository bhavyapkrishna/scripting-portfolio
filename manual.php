<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Scripting Manual</h1>
    <p>Input the manual you want to access from the <a href="https://man7.org/linux/man-pages/dir_all_by_section.html">man7 manual directory</a>, and the section within the manual you would like to read.</p>
    <p>This program will output the specific section of the manual you need!</p>
    <br>
    <form name="script-form" action="" method="get">
        <p>Enter the manual you want to access: </p> <input type="text" name="script" id="script">

        <p>Enter the function you want to access: </p> <input type="text" name="function" id="function">

        <br>
        <br>
        <input type="submit" value="Submit">
        <br>
    </form>

    <?php

    $directory = file_get_contents("https://man7.org/linux/man-pages/dir_all_by_section.html");
    $scriptDOM = new DOMDocument();
    $scriptDOM->loadHTML($directory);

    if (isset($_GET['script'])) {
        $script = $_GET['script'];
    } else {
        $script = '';
    }

    if (substr($script, -4) != '(1p)') {
        $end = '1';
    } else {
        $end = '1p';
        $script = substr($script, 0, -4);
    }

    $completeString = $script . '(' . $end . ')';
    $urlStr = $script . '.' . $end;

    $scriptPath = new DOMXPath($scriptDOM);
    $scriptQuery = "//a[text()='$completeString']/@href";

    $file = file_get_contents("https://man7.org/linux/man-pages/man1/$urlStr.html");
    $titleDOM = new DOMDocument();
    $titleDOM->loadHTML($file);

    $titlePath = new DOMXPath($titleDOM);
    $titleQuery = "//title";

    $title = $titlePath->query($titleQuery);

    if ($title->length > 0) {
        echo 'MANUAL: ' . $title->item(0)->nodeValue;
        echo "<br>";
        echo "<br>";
    } else {
        echo "Invalid title!";
        echo "<br>";
        echo "<br>";
    }
    
    if (isset($_GET['function'])) {
        $function = $_GET['function'];
    } else {
        $function = '';
    }

    $function = str_replace(' ', '_', $function);
    $function = strtoupper($function);

    $sectionQuery = "//a[@id='$function']/parent::h2/following-sibling::pre[1]";

    $section = $titlePath->query($sectionQuery);

    if ($section->length > 0) {
        echo $function;
        echo "<br>";
        echo $titleDOM->saveHTML($section->item(0));
    } else {
        echo "Invalid section!";
    }
    ?>
</body>

</html>