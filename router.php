<!DOCTYPE html>
<html>

<?php

$time_start = microtime(true);
$request_time = $_SERVER['REQUEST_TIME_FLOAT'];

include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

echo "<style>html { background-color: #4A226E; }</style>";


$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

$request = ltrim($request, "/");

$request = (array)explode("/", $request);

$arguments = $request;
array_shift($arguments);

$templates = [
    "basic" => [
        "name" => "basic",
        "path" => "basic.php"
    ]
];

include("routing.php");

$page_name = $request[0];

$meta_template = [
    "name" => "Tanza - Unknown Page",
    "description" => "We don't know what this page is."
];

$found = false;



foreach ($pages as $page) {
    if ($page['name'] == $page_name) {
        $found = true;
        $ref_page = $page;
    }
}



?>

<head>
    <?php
    // TODO: print meta here
    ?>
    <script rel="preload" src="https://kit.fontawesome.com/91ad005f46.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <?php
    Css("global/css/main.css");
    Css("css/" . $ref_page['name'] . ".css");
    ?>
</head>

<body>
    <div class="background"></div>
    <?php
    include("components/navbar.php");
    ?>
    <div class="page <?= implode(' ', $ref_page['extra_classes']); ?>">
        <?php
        if ($found == true) {
            ob_start();
            if (isset($ref_page['page'])) {
                include "views/" . $ref_page['page'];
            } else {
                include "views/" . $ref_page['name'] . "/" . $ref_page_inner['page'];
            }
            $meta = $meta_template;
            $page = ob_get_clean();
            ob_end_flush();
        }
        ob_start();
        if ($found == true) {
            if (isset($ref_page['template']) && $ref_page['template'] != "none") {
                // if 404 is called it wipes all page content
                $template = $templates[$ref_page['template']];
                include("templates/" . $template['path']);
            } else {
                echo $page;
            }
        } else {
            echo "404";
        }
        ?>
    </div>
</body>

<?php
foreach($ref_page['js'] as $js) {
    Js($js);
}

foreach($ref_page['css'] as $css) {
    Css($css);
}
Js("global/js/global.js");
Js("js/" . $ref_page['name'] . ".js");

$time = microtime(true) - $time_start;
$time = round($time, 4);
?>

</html>