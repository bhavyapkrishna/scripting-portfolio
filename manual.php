<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Scripting Manual</h1>
    <form name="script-form" action="" method="get">
        <p>Enter the manual you want to access: </p>
        <input type="text" name="script" id="script">
    </form>
    <br>
    <form name="function-form" action="" method="get">
        <p>Enter the function you want to access: </p>
        <input type="text" name="function" id="function">
    </form>

   <?php 
   $file = file_get_contents("https://www.man7.org/linux/man-pages/man1/bash.1.html");

   $dom = new DOMDocument();
   $dom->loadHTML($file);

   if(isset($_GET['function'])) {
    $function = $_GET['function'];
   } else {
    $function = '';
   }

   $function = str_replace(' ', '_', $function);
   $function = strtoupper($function);

   $path = new DOMXPath($dom);
   $sectionQuery = "//a[@id='$function']/parent::h2/following-sibling::pre[1]";

   $section = $path->query($sectionQuery);

   if ($section->length > 0) {
    echo $function;
    echo $dom->saveHTML($section->item(0));
   } else {
    echo "Invalid section!";
   }
   ?> 
</body>
</html>
