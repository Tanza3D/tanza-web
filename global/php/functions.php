<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
include("osekaiDB.php");
function Js($path) {
    echo '<script src="/'.$path.'"></script>';
}
function Css($path) {
    echo '<link rel="stylesheet" href="/'.$path.'">';
}
function Redirect($url) {
    // redirects by placing js on the page
    // usage: redirect("url");

    echo "<script>
    window.location.href = '" . $url . "';
    </script>";
    exit;
}