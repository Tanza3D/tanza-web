<?php
$base = json_decode(file_get_contents("https://www.hubza.co.uk/api/portfolio.php"), true);
foreach ($base as $item) {
    $id = $item['id'];
    $root = $_SERVER['DOCUMENT_ROOT'] . "/img/portfolio/" . $id . "/";
    mkdir($root);
    $name = $item['title'];
    $description = $item['subtitle'];
    $images = [];
    $date = date("Y-m-d", strtotime($item['date']));

    $counter = 0;
    foreach ($item['images'] as $image) {
        $ext = explode(".", $image["link"]);
        $path = $root . $counter . "." . end($ext);
        $localpath = $counter . "." . end($ext);
        echo $path;

        file_put_contents($path, file_get_contents("https://www.hubza.co.uk/" . $image['link']));

        $images[] = [
            "path" => $localpath,
            "name" => $image['alt'] // this is dumb
        ];
        $counter++;
    }
    
    echo $date;
    echo $description;

    Database::execOperation("INSERT INTO `Portfolio` (`Id`, `Images`, `Name`, `Description`, `Date`)
VALUES (?,?,?,?,?);", "issss", [
            $id,
            json_encode($images),
            $name,
            $description,
            $date
        ]);
}