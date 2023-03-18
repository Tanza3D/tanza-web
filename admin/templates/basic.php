<div class="admin__panel">
    <div class="admin__panel-navigation">
        <div class="admin__panel-navigation-header">
            <p>Admin Panel</p>
            <small>Logged in as <strong><?php echo $_SESSION['username']; ?></strong></small>
        </div>
        <div class="admin__panel-navigation-inner">
            <?php
            foreach($pages as $xpage) {
                $classes = "";
                if($xpage['name'] == $ref_page['name']) {
                    $classes = "admin__page-active";
                }
                echo '<a href="/admin/'.$xpage['name'].'" class="admin__page '.$classes.'">'.$xpage['display_name'].'</a>';
            }
            ?>
        </div>
    </div>
    <div class="admin__panel-content">
        <?php echo $page; ?>
    </div>
</div>