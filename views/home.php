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

<svg width="0" height="0" style="position: absolute;">
    <!-- even though its 0x0 width it still shoves the cover down around 30px, so have to hide it. idk -->
    <clipPath id="svgclip" clipPathUnits="objectBoundingBox">
        <path d="M1 0V1H0.153333L0.135556 0.996454L0.119111 0.985106L0.104 0.958865L0 0.243262L0.0608889 0.0212766L0.0795556 0H1Z"/>
    </clipPath>
</svg>


<div class="cover desktop">
    <div class="cover-background"></div>
    <div class="cover-inner">
        <div class="home__cover-desktop-background">
            <div class="home__cover-desktop-background-image">

            </div>
            <div class="home__cover-desktop-background-blur">

            </div>
            <div class="home__cover-desktop-content">
                <div class="home__cover-desktop-content-text">
                    <p>Hey, I'm</p>
                    <h1>Tanza!</h1>
                </div>
                <div class="home__cover-desktop-content-text-inner">
                    <h1>I create 3D models, websites, designs, games, apps, and more!</h1>

                    <p>This page is primarily designed to be a directory of links and pages, a place to view all my art, and an easy way to get to my refsheet.</p>

                    <p>Believe it or not, I’m a furry, and on the left is my protogen, which I've been 3d modelling from scratch since 2021 using Blender! (https://blender.org). I'm constantly improving the model!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cover mobile">
    <div class="cover-background"></div>
    <div class="cover-inner">
        COVER FOR MOBILE
    </div>
</div>

<div class="page-content">
    <div class="page-inner">
        uwu page
    </div>
</div>