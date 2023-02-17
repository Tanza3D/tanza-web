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
        <path d="M1 0V1H0.153333L0.135556 0.996454L0.119111 0.985106L0.104 0.958865L0 0.243262L0.0608889 0.0212766L0.0795556 0H1Z" />
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

                    <p>This page is your go-to place to find everything I do! There's a Gallery with all the 3D art I've created, a Portfolio page with all the designs I've made, and a Projects page with all the projects I've worked on over the years, such as Osekai, UNTONE ID, Cubey, and more!</p>

                    <p>On the left here is my character<small style="font-size: 60%; opacity: 0.5">fursona</small> Tanza! I've modelled him over the past few years from scratch using Blender! (https://blender.org). I'm constantly improving the model!</p>
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

<div class="page-content" aload="home" loadelement="window">
    <div class="page-inner">
        <div class="home__panels" id="homepanelsarea">
            <div class="home__panels-left">
                <div hover="big" click="big" class="home__panel home__panel-large">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-photo-video"></i></div>
                    <h1>Gallery</h1>
                </div>
                <div hover="big" click="big" class="home__panel home__panel-large" style="
                --col1: #2400FF;
                --col2: #0094FF;
                --col3: #2400FF;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-layer-group"></i></div>
                    <h1>Portfolio</h1>
                </div>
                <div hover="big" click="big" class="home__panel home__panel-large" style="
                --col1: #00D1FF;
                --col2: #2FC37C;
                --col3: #00FFE0;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-project-diagram"></i></div>
                    <h1>Projects</h1>
                </div>
            </div>
            <div class="home__panels-right">
                <div hover="small" click="big" class="home__panel home__panel-medium" style="
                --col1: #0066FF;
                --col2: #F042FF;
                --col3: #2400FF;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-info-circle"></i></div>
                    <h1>About Me</h1>
                    <p>Learn all about me, my history, and my plans for the future!</p>
                </div>
                <div hover="small" click="big" class="home__panel home__panel-medium" style="
                --col1: #8F00FF;
                --col2: #FF2F6D;
                --col3: #FF5C00;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-paint-brush"></i></div>
                    <h1>Refsheet</h1>
                    <p>Check out my Protogen’s refsheet here! It’s super long!</p>
                </div>
                <div hover="small" click="big" class="home__panel home__panel-medium" style="
                --col1: #FF007A;
                --col2: #9712FF;
                --col3: #0047FF;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fas fa-envelope"></i></div>
                    <h1>Work / Contact</h1>
                    <p>Want some design work done? Contact me here!</p>
                </div>
                <div hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #6261E1;
                --col2: #469ACD;
                --col3: #43C3B8;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fab fa-twitter"></i></div>
                    <h1>Twitter</h1>
                </div>
                <div hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #8B3DE7;
                --col2: #6F7DD4;
                --col3: #64ACBD;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fab fa-discord"></i></div>
                    <h1>Discord</h1>
                </div>
                <div hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #5C4EE4;
                --col2: #4E78E4;
                --col3: #AB4EE4;
                ">
                    <div class="home__panel-sheen"></div>
                    <div class="icon"><i class="fab fa-mastodon"></i></div>
                    <h1>Mastodon</h1>
                </div>
            </div>
        </div>
    </div>
</div>