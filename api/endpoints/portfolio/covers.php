<?php
// prepare for cursedness
$albums = json_decode(file_get_contents("https://music.untone.uk/data/albums"), true);

$export = [];

foreach($albums as $album) {
    if($album["Designer"] == 1) {
        $export[] = [
            "Name" => $album['Name'],
            "Description" => "Album art for " . $album['Name'],
            "Date" => $album['ReleaseDate'],
            "Link" => "https://music.untone.uk/release/" . $album['Key'],
            "Type" => "2",
            "Ratio" => "1:1",
            "SimpleRatio" => "square",
            "Images" => [
                [
                    "path" => "https://music.untone.uk/img_dl/" . $album['Image'],
                    "name" => "Cover Art"
                ]
            ],
            "imageurl" => "https://music.untone.uk/img/" . $album['Image']
        ];
    }
}

echo json_encode($export);