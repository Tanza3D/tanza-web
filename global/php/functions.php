<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
include("osekaiDB.php");
function Js($path) {
    echo '<script src="/'.$path.'"></script>';
}
function Css($path) {
    echo '<link rel="stylesheet" href="/'.$path.'">';
}