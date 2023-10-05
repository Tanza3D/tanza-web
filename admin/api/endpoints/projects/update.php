<?php

$internalName = $_REQUEST['internalName'];
echo $internalName;

$name = $_REQUEST['name'];
$description = $_REQUEST['description'];
$extraDescription = $_REQUEST['extraDescription'];

$badge = $_REQUEST['badge'];
$popup = $_REQUEST['popupData'];
$size = $_REQUEST['size'];
$date = $_REQUEST['date'];
$order = $_REQUEST['order'];


Database::execOperation("UPDATE `Projects` SET `Name` = ?,`Description` = ?,`Badge` = ?,`Popup` = ?,`Size` = ?,`Date` = ?,`Order` = ?, `ExtraDescription` = ? WHERE InternalName = ?", "ssssssiss",
[
    $name,
    $description,
    $badge,
    $popup,
    $size,
    $date,
    $order,
    $extraDescription,
    $internalName,
]);