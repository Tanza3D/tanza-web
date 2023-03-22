<?php
$items = Database::execSimpleSelect("SELECT * FROM Gallery ORDER BY Date DESC");
$first = false;
$batches = [];
$batch = [];
$counter = 0;
$limit = 2.4;
foreach ($items as $item) {
    $batch[] = $item;

    $qr = explode(":", $item['Ratio']);
    $counter += $qr[0] / $qr[1];

    if ($counter >= $limit || ($first == false && $item['SimpleRatio'] == "wide")) {
        $counter = 0;
        $first = true;
        $batches[] = $batch;
        $batch = [];
    }
}
echo json_encode($batches);