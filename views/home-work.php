<style>
    .cover-background {
        background-image: url('/img/gallery/small/1664732666_sick%20glass%20shit.png');
        background-size: cover;
        background-position: center;
        <?php if ($images[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1);';
        }
        ?>
    }
</style>

<style id="covers">
    .cover-background-2 {
        background-image: url('/img/gallery/original/1664732666_sick%20glass%20shit.png');
        background-size: cover;
        background-position: center;
        <?php if ($images[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1);';
        }
        ?>
    }
</style>

<img class="mobile" style="display: none" src="/img/gallery/small/<?= $images_mobile[0]['Filename']; ?>">
<img media="(orientation:portrait)" class="desktop" style="display: none"
    src="/img/gallery/small/<?= $images[0]['Filename']; ?>">

<svg width="0" height="0" style="position: absolute;">
    <!-- even though its 0x0 width it still shoves the cover down around 30px, so have to hide it. idk -->
    <clipPath id="svgclip" clipPathUnits="objectBoundingBox">
        <path
            d="M1 0V1H0.153333L0.135556 0.996454L0.119111 0.985106L0.104 0.958865L0 0.243262L0.0608889 0.0212766L0.0795556 0H1Z" />
    </clipPath>
</svg>


<div class="cover work" id="loadDetector">
    <div class="cover-background" id="lowq-bg"></div>
    <div class="cover-background cover-background-2" id="highq-bg"></div>
    <div class="cover-inner work">
        <h1>Hey, I'm <strong>Archie Williams</strong> - also known as Tanza</h1>
        <p>I do graphic design, programming, 3d art, and more. Please look below to see my work!</p>
    </div>
</div>

<?php
include("work.html");
?>
<div class="page-content" aload="home" loadelement="window">
    <div class="page-inner">
        <div>
            <p class="work-intro">
                I primarily do design work, for websites, apps, games, brands, and various other things!</p>
            <p class="work-intro">
                Most notably, I've done official designs for <a href="https://osu.ppy.sh">osu!</a>, along with various
                community-ran tournaments of the game.
            </p>
            <p class="work-intro">
                I also make and work on websites myself, such as <a href="https://reddark.untone.uk">Reddark</a>,
                <a href="https://osekai.net">Osekai</a>, <a href="https://id.untone.uk/">UNTONE ID</a>, and of course
                this
                website itself!
            </p>
        </div>
        <div class="home__panels" id="homepanelsarea">
            <div class="home__panels-left">
                <a hover="big" click="big" class="home__panel home__panel-large home__panel-portfolio" style="
                --col1: #2400FF;
                --col2: #0094FF;
                --col3: #2400FF;
                " href="/portfolio">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-layer-group"></i></div>
                    <h1>Design<br>Portfolio</h1>
                    <?php
                    $portfolios = Database::execSimpleSelect("SELECT * FROM Portfolio LIMIT 3");
                    foreach ($portfolios as $portfolio) {
                        $images = json_decode($portfolio['Images'], true);

                        echo '<img loading="lazy" class="lazy home__portfolio-image desktop" data-src="/img/portfolio/' . $portfolio['Id'] . '/' . $images[0]['path'] . '">';
                    }
                    ?>
                </a>
                <a id="firstpanel" hover="big" click="big" class="home__panel home__panel-large home__panel-projects"
                    style="
                --col1: #00D1FF;
                --col2: #2FC37C;
                --col3: #00FFE0;
                height: 300px;
                " href="/projects">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-project-diagram"></i></div>
                    <h1>Projects</h1>
                    <p>
                        <?php
                        $projects = Database::execSimpleSelect("SELECT * FROM Projects");
                        foreach ($projects as $project) {
                            echo "<span class=\"desktop\">" . $project['Name'] . "</span>";
                        }
                        ?>
                    </p>
                </a>

                <a hover="big" click="big" class="home__panel home__panel-large home__panel-gallery" href="/gallery"
                    style="height: 250px;">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-photo-video"></i></div>
                    <h1>3D Art<br>Gallery</h1>
                </a>

            </div>
            <div class="home__panels-right">
            <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #5C4EE4;
                --col2: #4E78E4;
                --col3: #AB4EE4;
                " href="https://www.linkedin.com/in/archie-" target="_blank">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fab fa-linkedin"></i></div>
                    <h1>LinkedIn</h1>
                    </a>
                <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #8B3DE7;
                --col2: #6F7DD4;
                --col3: #64ACBD;
                " onclick="openLayer('layer_discord')">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fab fa-discord"></i></div>
                    <h1>Discord</h1>
                </a>
                    <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #191C44;
                --col2: #161B22;
                --col3: #394049;
                " href="https://github.com/tanza3d" target="_blank">
                        <div class="home__panel-sheen desktop"></div>
                        <div class="icon"><i class="fab fa-github"></i></div>
                        <h1>Github</h1>
                    </a>
                    <div hover="small" click="layer" class="home__panel home__panel-medium" style="
                --col1: #FF007A;
                --col2: #9712FF;
                --col3: #0047FF;
                " onclick="openLayer('layer_contact')">
                        <div class="home__panel-sheen desktop"></div>
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <h1>Work / Contact</h1>
                        <p>Want some design work done? You can contact me here.</p>
                    </div>
                    <div hover="small" click="layer" class="home__panel home__panel-medium" style="
                --col1: #FFC700;
                --col2: #FFD770;
                --col3: #FFC700;
                " href="https://untone.uk">
                        <div class="home__panel-sheen desktop"></div>
                        <div class="icon"><i class="fas fa-smile"></i></div>
                        <h1>UNTONE</h1>
                        <p>UNTONE</p>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="layer layer-closed" id="layer_discord">
    <div class="layer__close-layer" onclick="closeLayer()"></div>
    <div class="home__discord">
        <div class="home__discord-inner">
            <img src="/img/gallery/small/1672686538_pfp-2023-2.png">
            <div class="home__discord-texts">
                <p>Add me on Discord!</p>
                <h1><strong>@Tanza3D</strong></h1>
            </div>
        </div>
    </div>
</div>

<div class="layer layer-closed" id="layer_contact">
    <div class="layer__close-layer" onclick="closeLayer()"></div>
    <div class="layer__content">
        <div class="layer__header">
            <h1>Work / Contact</h1>
            <i class="fas fa-times-circle" onclick="closeLayer()"></i>
        </div>
        <div class="layer-text-content">
            <p>The best way to contact me is through Discord. You can do so by adding me at @Tanza3D.</p>
            <p>You can also send me an email at archie@untone.uk if that's preferred!</p>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>

<script>
    var lazyLoadInstance = new LazyLoad({
        // Your custom settings go here
    });
</script>