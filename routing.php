<?php
$pages = [];

function addPage($name, $displayname, $page="404.php", $template="basic", $extra=[""]) {
    global $pages;
    $pages[$name] = [
        "name" => $name,
        "display_name" => $displayname,
        "page" => $page,
        "template" => $template,
        "extra_classes" => $extra
    ];
}

addPage("home", "Home", "home.php", "basic", ["page-with-cover"]);