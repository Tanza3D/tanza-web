<div class="cover cover-small">
    <h1>Past work</h1>
    <p>This page is of other work I've done, which I couldn't really list as a "Project", but that I still played an important part in.<p>
</div>

<div class="page-content">
    <div class="page-inner">
        <!-- <div class="pw__collapsable">
            <div class="pw__collapsable-top">
                <h1>CEX Stock Display</h1>
            </div>
            <div class="pw__collapsable-content">
                <p>Although <a href="https://chromb.uk">George</a> did the designs, and ran in-store tests of the idea,
                    I
                    developed the technologies behind it.</p>
                <img src="/img/past-work/cex/Screenshot from 2023-10-04 22-16-15.png">
            </div>
        </div> -->


        <?php
        $data = Database::execSimpleSelect("SELECT * FROM Projects ORDER BY `Order` DESC");
        foreach ($data as $project) {
            //print_r($project);
            $content = "";
            $link = "";
            //print_r($project);
            if (str_starts_with($project['Popup'], "link:")) {
                $link = str_replace("link:", "", $project['Popup']);
            } else {
                $content = str_replace("html:", "", $project['Popup']);
            }
            ?>
            <div class="pw__collapsable">
                <a class="pw__collapsable-top" <?php
                if ($link != null) {
                    echo 'href="' . $link . '"';
                }
                ?>>
                    <h1>
                        <?= $project['Name'] ?>
                    </h1>
                    <?php
                    if($project['Logo'] != "") {
                        echo '<img src="'.$project['Logo'].'">';
                    }
                    ?>
                </a>
                <div class="pw__collapsable-content">
                    <h3>
                        <?= $project['Description'] ?>
                    </h3>
                    <?= $project['ExtraDescription'] ?>
                    <?= $content ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>