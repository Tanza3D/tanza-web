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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <?php
    Css("global/css/main.css");
    Css("css/" . $ref_page['name'] . ".css");
    ?>
    <script>
        const page = "<?= $ref_page['name'] ?>";
    </script>
    <style>
        .cover-small {
            background-image: url("/public/img/covers/<?= $ref_page['name'] ?>.png");
        }
    </style>
</head>

<body>
    <div id="page_loading_overlay" class="loadingoverlay">
        <svg width="252" height="243" viewBox="0 0 252 243" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_dddddddd_505_43)">
                <path class="loader-thin"
                    d="M136.825 81.75L170.6 140.25C175.412 148.583 169.397 159 159.775 159H92.225C82.6025 159 76.5884 148.583 81.3997 140.25L115.175 81.75C119.986 73.4167 132.014 73.4167 136.825 81.75Z"
                    stroke="#D8A3FF" stroke-width="3"></path>
            </g>
            <g>
                <path opacity="0.25"
                    d="M136.825 81.75L170.6 140.25C175.412 148.583 169.397 159 159.775 159H92.225C82.6025 159 76.5884 148.583 81.3997 140.25L115.175 81.75C119.986 73.4167 132.014 73.4167 136.825 81.75Z"
                    stroke="#D8A3FF" stroke-width="16"></path>
            </g>
            <defs>
                <filter id="filter0_dddddddd_505_43" x="0.204102" y="0" width="251.592" height="242.5"
                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                        result="hardAlpha"></feColorMatrix>
                    <feOffset dy="4"></feOffset>
                    <feGaussianBlur stdDeviation="8.5"></feGaussianBlur>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.291667 0 0 0 0 0.3625 0 0 0 0 1 0 0 0 1 0">
                    </feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_505_43"></feBlend>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                        result="hardAlpha"></feColorMatrix>
                    <feOffset dy="4"></feOffset>
                    <feGaussianBlur stdDeviation="8.5"></feGaussianBlur>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.291667 0 0 0 0 0.3625 0 0 0 0 1 0 0 0 1 0">
                    </feColorMatrix>

                    <feBlend mode="normal" in2="effect7_dropShadow_505_43" result="effect8_dropShadow_505_43"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect8_dropShadow_505_43" result="shape"></feBlend>
                </filter>
            </defs>
        </svg>
        <p>Loading</p>
    </div>
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
foreach ($ref_page['js'] as $js) {
    Js($js);
}

foreach ($ref_page['css'] as $css) {
    Css($css);
}
Js("global/js/global.js");
Js("js/" . $ref_page['name'] . ".js");

$time = microtime(true) - $time_start;
$time = round($time, 4);
?>

</html>