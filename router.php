<!DOCTYPE html>
<html>

<?php

$time_start = microtime(true);
$request_time = $_SERVER['REQUEST_TIME_FLOAT'];
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
if(HAS_SHARED) include("/var/www/share/untoneShared.php");

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

echo "<style>html { background-color: #4A226E; }</style>";


$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

$request = ltrim($request, "/");

$request = (array) explode("/", $request);

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

$embed = new Embed();

$func = array($embed, $ref_page['name']);
$func();

?>

<head>
    <meta name="title" content="<?= $embed->embed_name ?>">
    <meta name="description" content="<?= $embed->embed_description ?>">
    <meta name="keywords" content="<?= $embed->embed_keywords ?>">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Tanza">
    <meta name="theme-color" content="#EC0DEE" />

    <meta name="twitter:site" content="@tanza3d">
    <meta name="twitter:title" content="<?= $embed->embed_name ?>">
    <meta name="twitter:description" content="<?= $embed->embed_description ?>">
    <meta name="twitter:card" content="summary_large_image">


    <?php
    if ($embed->embed_thumbnail != "") {
        echo '<meta name="twitter:image:src" content="' . $embed->embed_thumbnail . '">';
    }
    ?>

    <meta name="viewport" content="width=device-width, initial-scale=0.9" />
    <script rel="preload" src="https://kit.fontawesome.com/91ad005f46.js" crossorigin="anonymous"></script>
    <?php
    Css("global/css/main.css");
    if ($isWork) {
        Css("global/css/work.css");
    }
    Css("css/" . $ref_page['name'] . ".css");
    ?>
    <script>
        const page = "<?= $ref_page['name'] ?>";
    </script>
</head>

<body class="body-<?= $ref_page['name'] ?> loaded">
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

    <?php if(!$isWork && false) { ?>
    <div hover="smaller" click="normal" class="donate-button" style="
                --col1: #EB00FF;
                --col2: #F7AF01;
                --col3: #EB00FF;
                " target="_blank">
                <p>Like what I do? Send over a donation! It'll help me to keep doing what I love to do, and making cool things for everyone :3</p>
        <?php if (HAS_SHARED)
            UNTONE\Shared::DonationButton(
                "",
                "Thanks alot for the donation! It really helps me to keep doing what I like to do :3",
            ); ?>
    </div>
    <?php } ?>
</body>

<?php
foreach ($ref_page['js'] as $js) {
    Js($js."");
}

foreach ($ref_page['css'] as $css) {
    Css($css."");
}
Js("global/js/global.js");
if ($isWork) {
    Css("global/js/work.js");
}
Js("js/" . $ref_page['name'] . ".js");

$time = microtime(true) - $time_start;
$time = round($time, 4);
?>

</html>