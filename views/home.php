<?php
$images = Database::execSimpleSelect("SELECT * FROM Gallery
WHERE Ratio = '16:9' AND ForHomepage != 0
ORDER BY RAND()
LIMIT 1");

$images_mobile = Database::execSimpleSelect("SELECT * FROM Gallery
WHERE SimpleRatio = 'tall' AND ForHomepage != 0
ORDER BY RAND()
LIMIT 1");
?>
<style>
    .cover-background {
        background-image: url('/img/gallery/original/<?= $images[0]['Filename']; ?>');
        background-size: cover;
        background-position: center;
        <?php if ($images[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1);';
        }
        ?>
    }
    .mobile .cover-background {
        background-image: url('/img/gallery/original/<?= $images_mobile[0]['Filename']; ?>') !important;
        <?php if ($images_mobile[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1) !important;';
        } else {
            echo 'transform: none !important;';
        }
        ?>
    }
</style>

<div class="cover desktop">
    <div class="cover-background"></div>
    <div class="cover-inner">
        COVER FOR DESKTOP
    </div>
</div>
<div class="cover mobile">
    <div class="cover-background"></div>
    <div class="cover-inner">
        COVER FOR MOBILE
    </div>
</div>