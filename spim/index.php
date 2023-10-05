<?php
$array = [];
for($x = 0; $x < 40; $x++) {
    $formatted_value = sprintf("%02d", $x+1);
    echo '<img src="img/00'.$formatted_value.'.png" style="display: none;">';
    $array[] = 'img/00'.$formatted_value.'.png';
}
?>

<script>
var images = <?= json_encode($array); ?>;
</script>

<link href="main.css" rel="stylesheet">

<img src="img/0001.png" id="mainimg" draggable="false">

<script src="main.js?v2"></script>