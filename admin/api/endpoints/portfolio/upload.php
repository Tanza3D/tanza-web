<?php
$name = $_POST['name'];
$description = $_POST['description'];
$date = $_POST['date'];
$files = [];

$id = time();
$root = $_SERVER['DOCUMENT_ROOT'] . "/img/portfolio/" . $id . "/";
mkdir($root);

$counter = 0;
foreach($_FILES as $file) {
    $ext = explode(".", $file["name"]);
    $path = $root . $counter . "." . end($ext);
    $localpath = $counter . "." . end($ext);
    echo($path);
    if (move_uploaded_file($file["tmp_name"], $path)) {
        // it wroks trust me :)
    }
    $files[] = [
        "path" => $localpath,
        "name" => $_POST['imagedesc'.$counter] // this is dumb
    ];
    $counter++;
}

$link = $_POST['link'];


Database::execOperation("INSERT INTO `Portfolio` (`Id`, `Images`, `Name`, `Description`, `Date`, `Link`)
VALUES (?,?,?,?,?,?);", "isssss", [
    $id,
    json_encode($files),
    $name,
    $description,
    $date,
    $link
]);
