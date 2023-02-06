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

addPage("home", "Home", "home.php", "basic");
addPage("portfolio", "Portfolio", "portfolio.php", "basic");
addPage("projects", "Projects", "projects.php", "basic");
addPage("gallery", "Gallery", "gallery.php", "basic");
addPage("auth/login", "Login", "login.php", "basic");