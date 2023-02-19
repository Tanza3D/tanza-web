<?php
function convertImage($originalImage, $outputImage, $quality)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.', $originalImage);
    $ext = $exploded[count($exploded) - 1];

    if (preg_match('/jpg|jpeg/i', $ext))
        $imageTmp = imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i', $ext))
        $imageTmp = imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i', $ext))
        $imageTmp = imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i', $ext))
        $imageTmp = imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}

$rootpath = $_SERVER['DOCUMENT_ROOT'];
$root = "/img/projects/";

$internalName = $_REQUEST['internalName'];
$name = $_REQUEST['name'];
$description = $_REQUEST['description'];
$logo = "";
$badge = $_REQUEST['badge'];
$popup = $_REQUEST['popupData'];
$size = $_REQUEST['size'];
$date = $_REQUEST['date'];
$order = $_REQUEST['order'];

$root .= $internalName . "/";

$logo_name = $_FILES['logo']['name'];
$logo_format = substr($logo_name, strpos($logo_name, ".") + 1);
$logo = $root . "logo." . $logo_format;
$logo_path = $rootpath . $logo;

echo $logo_path;

mkdir($rootpath . $root);

if ($_FILES["logo"] != null) {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $logo_path)) {
        echo json_encode("The file " . htmlspecialchars(basename($_FILES["logo"]["name"])) . " has been uploaded.");
    } else {
        echo json_encode("Sorry, there was an error uploading your file.");
        exit;
    }
} else {
    $logo = "";
}

$temp_bg_pos = $rootpath . $root . $_FILES['background']['name'];

if ($_FILES["background"] != null) {
    $background = "";
    if (move_uploaded_file($_FILES["background"]["tmp_name"], $temp_bg_pos)) {
        echo json_encode("The file " . htmlspecialchars(basename($_FILES["background"]["name"])) . " has been uploaded.");
    } else {
        echo json_encode("Sorry, there was an error uploading your file.");
        exit;
    }

    convertImage($temp_bg_pos, $rootpath . $root . "background.jpg", 90);
    unlink($temp_bg_pos);
} else {
    $background = "/public/img/projects/noBackground.jpg";
}

echo $date;

Database::execOperation("INSERT INTO `Projects` (`InternalName`, `Name`, `Description`, `Background`, `Logo`, `Badge`, `Popup`, `Size`, `Date`, `Order`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", "sssssssssi",
[
    $internalName,
    $name,
    $description,
    $background,
    $logo,
    $badge,
    $popup,
    $size,
    $date,
    $order
]);