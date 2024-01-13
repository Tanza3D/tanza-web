<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
include("osekaiDB.php");
function Js($path, $local = true) {
    if($local == true) {
        $path = "/" . $path;
    }
    echo '<script src="'.$path.'?v=6"></script>';
}
function Css($path) {
    echo '<link rel="stylesheet" href="/'.$path.'?v=6">';
}
function Redirect($url) {
    // redirects by placing js on the page
    // usage: redirect("url");

    echo "<script>
    window.location.href = '" . $url . "';
    </script>";
    exit;
}