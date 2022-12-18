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
    <defs>
        <clipPath id="svgclip">
            <path fill="#FFFFFF" stroke="#000000" stroke-width="1.5794" stroke-miterlimit="10" d="M889 0V557H136.313L120.509 555.025L105.89 548.704L92.456 534.088L0 135.497L54.1302 11.8511L70.7249 0H889Z" fill="#D9D9D9" />
        </clipPath>
    </defs>
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