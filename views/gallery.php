<div class="cover">

</div>



<div class="page-content">
    <div id="gallery" class="gallery">
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

        function printItem($item)
        {
            $ratio = explode(":", $item['Ratio']);
            echo '<div style="--ratio: ' . $ratio[0] . ' / ' . $ratio[1] . ';" class="item"><img class="lazy" src="/public/img/gallery/' . $item['SimpleRatio'] . '.png" data-src="/img/gallery/small/' . $item['Filename'] . '"></div>';
        }

        $month = 0;
        $year = 0;
        $yearstarted = false;
        $firstmonthofyear = false;

        foreach ($batches as $batch) {
            $class = "item-batch-double";

            $time = strtotime($batch[0]['Date']);
            $cmonth = date("F", $time);
            $cyear = date("Y", $time);
           
            if (count($batch) == 1) {
                $class = "item-batch-single";
            }
            if($cyear != $year) {
                $year = $cyear;
                if($yearstarted == true) {
                    echo "</div>";
                }
                $yearstarted = true;
                $firstmonthofyear = true;
                echo "<div class=\"year-section\">";
                echo "<h1>".$year."</h1>";
            }
            echo '<div class="item-batch ' . $class . '">';

            if($cmonth != $month) {
                $month = $cmonth;
                if($firstmonthofyear == true) {
                    echo "<h2 class=\"first\">".$month."</h2>";
                    $firstmonthofyear = false;
                } else echo "<h2>".$month."</h2>";
            }

            foreach ($batch as $item) {
                printItem($item);
            }
            echo "</div>";
        }
        echo "</div>";

        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
<script>
    var lazyLoadInstance = new LazyLoad({
        // Your custom settings go here
    });
</script>