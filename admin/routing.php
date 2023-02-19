<?php
$pages = [];

function addPage($name, $displayname, $page="404.php", $template="basic", $extra=[""], $css=[], $js=[]) {
    global $pages;
    $pages[$name] = [
        "name" => $name,
        "display_name" => $displayname,
        "page" => $page,
        "template" => $template,
        "extra_classes" => $extra,
        "js" => $js,
        "css" => $css
    ];
}

addPage("home", "Home", "home.php", "basic");
addPage("portfolio", "Portfolio", "portfolio.php", "basic");
addPage("projects", "Projects", "projects.php", "basic", [], ["global/css/projects/projectPanel.css"], ["global/js/projects/projectPanel.js"]);
addPage("gallery", "Gallery", "gallery.php", "basic");
addPage("auth/login", "Login", "login.php", "basic");