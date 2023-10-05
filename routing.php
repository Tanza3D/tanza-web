<?php
$pages = [];
$embeds = [];

function addPage($name, $displayname, $page = "404.php", $template = "basic", $extra = [""], $css = [], $js = [])
{
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

$isWork = false;

if ($_SERVER['SERVER_NAME'] == "tanza.work") {
    $isWork = true;
    addPage("home", "Home", "home-work.php", "basic", ["page-with-cover"]);
} else {
    addPage("home", "Home", "home.php", "basic", ["page-with-cover"]);
}

addPage("projects", "Projects", "projects.php", "basic", ["page-with-cover"], ["global/css/projects/projectPanel.css"], ["global/js/projects/projectPanel.js"]);
addPage("gallery", "Gallery", "gallery.php", "basic", ["page-with-cover"]);
addPage("portfolio", "Portfolio", "portfolio.php", "basic", ["page-with-cover"], ["global/css/projects/projectPanel.css"], ["global/js/projects/projectPanel.js"]);
addPage("past_work", "Past Work", "past-work.php", "basic", ["page-with-cover"], ["global/css/projects/projectPanel.css"], ["global/js/projects/projectPanel.js"]);

class Embed
{
    public $embed_name = "";
    public $embed_description = "";
    public $embed_thumbnail = "";
    public $embed_keywords = "tanza,tanza3d,hubz,osu,design,3d,art";

    public function home()
    {
        if ($_SERVER['SERVER_NAME'] == "tanza.work") {
            $this->embed_name = "Tanza / Home";
            $this->embed_description = "Hey, I'm Tanza! I do graphic design, programming, 3d art, and more. On this site you can find my work and portfolio!";
            $this->embed_thumbnail = "/img/portfolio/1683902886/0.png";
        } else {
            $this->embed_name = "Tanza / Home";
            $this->embed_description = "Hey, I'm Tanza! I create 3D models, websites, designs, games, apps, and more! This page is your go-to place to find everything i do! :3";
            $this->embed_thumbnail = "/img/gallery/small/1664705322_grass-unpatched.png";
        }
    }
    public function gallery()
    {
        $this->embed_name = "Tanza / Art Gallery";
        $this->embed_description = "Hey, I'm Tanza! Here you can find all the art I’ve created, from 2019 to now! Enjoy!";
        $this->embed_thumbnail = "/public/img/covers/gallery.png";
    }
    public function projects()
    {
        $this->embed_name = "Tanza / Projects";
        $this->embed_description = "Hey, I'm Tanza! Here you can find all the projects I’ve made in the past, or am actively working on!";
        $this->embed_thumbnail = "/public/img/covers/projects.png";
    }
    public function portfolio()
    {
        $this->embed_name = "Tanza / Portfolio";
        $this->embed_description = "Hey, I'm Tanza! Here you can find all of the designs I’ve worked on!";
        $this->embed_thumbnail = "/public/img/covers/portfolio.png";
    }
    public function past_work()
    {
        $this->embed_name = "Tanza / Past Work";
        $this->embed_description = "Past Work";
        $this->embed_thumbnail = "/public/img/covers/portfolio.png";
    }
}