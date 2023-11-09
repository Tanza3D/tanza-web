<div class="navbar">
    <div class="navbar__inner">
        <?php
        if (!$isWork) { ?>
            <a class="navbar__left" href="/">
                <img src="/public/img/logo.svg">
                <p>Tanza</p>
            </a>
            <?php
        } else {
            echo "<h1>Archie <light>Williams</light></h1>";
        }
        ?>
        <div class="navbar__right">
            <?php
            foreach ($pages as $page) {
                $active = "";
                if ($ref_page['name'] == $page['name']) {
                    $active = "navbar-button-active";
                }
                echo '<a click="normal" hover="small" href="/' . $page['name'] . '" class="navbar-button ' . $active . '">' . $page['display_name'] . '</a>';
            }
            ?>
        </div>
    </div>
    <div class="navbar__trim">

    </div>
</div>