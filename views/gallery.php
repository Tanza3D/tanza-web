<?php
$newest = Database::execSimpleSelect("SELECT * FROM Gallery WHERE SimpleRatio = 'wide' ORDER BY Date DESC LIMIT 10");
$newest = $newest[random_int(0, 9)];
$path = '/img/gallery/small/'.$newest['Filename'];
?>
<style>
    body {
        -a-backdrop: url("<?= $path ?>");
    }
</style>
</style>
<div class="cover cover-small">
    <img src="/img/gallery/small/<?=$newest['Filename']?>">
    <h1>Art Gallery</h1>
    <p>All the art I’ve created, from 2019 to now! Enjoy!<p>
</div>



<div class="page-content" aload="basic" loadelement="window">
    <div id="gallery" class="gallery">
        <div class="gallery-sidebar" id="gallery-sidebar">
            <!-- <div class="sidebar-year sidebar-year-active">
                <h1>2023</h1>
                <div class="sidebar-year-months">
                    <div class="sidebar-year-month">
                        <p>July</p><span>9</span>
                    </div>
                    <div class="sidebar-year-month sidebar-year-month-active">
                        <p>July</p><span>9</span>
                    </div>
                </div>
            </div>
            <div class="sidebar-year">
                <h1>2022</h1>
                <div class="sidebar-year-months">
                    <div class="sidebar-year-month">
                        <p>July</p><span>9</span>
                    </div>
                    <div class="sidebar-year-month">
                        <p>July</p><span>9</span>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="gallery-pictures" id="gallery-pictures">

        </div>
        <?php
        $local = false;
        if($local == true) {
            $items = Database::execSimpleSelect("SELECT * FROM Gallery ORDER BY Date DESC");
            $first = false;
            $batches = [];
            $batch = [];
            $counter = 0;
            $limit = 2.4;
            foreach($items as $item) {
                $batch[] = $item;

                $qr = explode(":", $item['Ratio']);
                $counter += $qr[0] / $qr[1];

                if($counter >= $limit || ($first == false && $item['SimpleRatio'] == "wide")) {
                    $counter = 0;
                    $first = true;
                    $batches[] = $batch;
                    $batch = [];
                }
            }

            function printItem($item) {
                $ratio = explode(":", $item['Ratio']);
                echo '<div style="--ratio: '.$ratio[0].' / '.$ratio[1].';" class="item"><img class="lazy" src="/public/img/gallery/'.$item['SimpleRatio'].'.png" data-src="/img/gallery/small/'.$item['Filename'].'"></div>';
            }

            $month = 0;
            $year = 0;
            $yearstarted = false;


            $yearcounts = [];
            $monthcounts = [];
            foreach($batches as $batch) {
                $time = strtotime($batch[0]['Date']);
                $cmonth = date("F", $time);
                $cyear = date("Y", $time);
                if(!isset($yearcounts[$cyear]))
                    $yearcounts[$cyear] = 0;
                $yearcounts[$cyear] += count($batch);

                if(!isset($monthcounts[$cyear.$cmonth]))
                    $monthcounts[$cyear.$cmonth] = 0;
                $monthcounts[$cyear.$cmonth] += count($batch);
            }

            $printsearchbar = true;

            foreach($batches as $batch) {
                $class = "item-batch-double";

                $time = strtotime($batch[0]['Date']);
                $cmonth = date("F", $time);
                $cyear = date("Y", $time);

                if(count($batch) == 1) {
                    $class = "item-batch-single";
                }
                if($cyear != $year) {
                    $year = $cyear;
                    if($yearstarted == true) {
                        echo "</div>";
                    }
                    $yearstarted = true;
                    echo "<div class=\"year-section\">";
                    echo "<div class=\"year-text\"><h1>".$year."</h1><span>".$yearcounts[$year]."</span></div>";
                }
                if($cmonth != $month) {
                    $month = $cmonth;
                    echo "<div class=\"month-text\"><h2 class=\"first\">".$month."</h2><span>".$monthcounts[$year.$month]."</span></div>";
                }

                echo '<div class="item-batch '.$class.'">';

                foreach($batch as $item) {
                    printItem($item);
                }
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
<div class="image-popup image-popup-hidden" id="image-popup">
    <img src="" class="image-popup-blur-bg" id="ip-bg" onclick="closePopup()">
    <div class="image-popup-container">
        <div class="image-popup-img-container">
            <img src="" class="image-popup-img" id="ip-mi">
        </div>
        <div class="image-popup-sidebar">
            <h1 id="ip-title">TITLE</h1>
            <h3 id="ip-date"></h3>
            <p id="ip-description">info</p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
<script>

</script>