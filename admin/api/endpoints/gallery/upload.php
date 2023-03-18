<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/img/gallery/original/";

$name = $_POST['Name'];
$date = null;
if (isset($_POST['Date'])) {
    $date = $_POST['Date'];
}

$id = time();

$target_dir = $root;
$filename = $id . "_" . basename($_FILES["Image"]["name"]);
$target_file = $target_dir . $filename;

if (is_dir($target_dir) && is_writable($target_dir)) {
    if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
        //echo json_encode("The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.");
    } else {
        echo json_encode("Sorry, there was an error uploading your file.");
        echo $_FILES["Image"]["error"];
        exit;
    }
} else {
    echo 'Upload directory is not writable, or does not exist - ' . $target_dir;
    exit;
}

Database::execOperation("INSERT INTO `Gallery` (`Id`, `Date`, `Filename`, `Name`, `Description`) VALUES (?,?,?,?,'');", "isss", [$id, $date, $filename, $name]);
$item = Database::execSimpleSelect("SELECT * FROM Gallery ORDER BY Id DESC LIMIT 1")[0];
echo json_encode($item);
