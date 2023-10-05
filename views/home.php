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
        background-image: url('/img/gallery/small/<?= $images[0]['Filename']; ?>');
        background-size: cover;
        background-position: center;
        <?php if ($images[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1);';
        }
        ?>
    }

    .mobile .cover-background {
        background-image: url('/img/gallery/small/<?= $images_mobile[0]['Filename']; ?>') !important;
        <?php if ($images_mobile[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1) !important;';
        } else {
            echo 'transform: none !important;';
        }
        ?>
    }
</style>

<style id="covers">
    .cover-background-2 {
        background-image: url('/img/gallery/small/<?= $images[0]['Filename']; ?>');
        background-size: cover;
        background-position: center;
        <?php if ($images[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1);';
        }
        ?>
    }

    .mobile .cover-background-2 {
        background-image: url('/img/gallery/small/<?= $images_mobile[0]['Filename']; ?>') !important;
        <?php if ($images_mobile[0]['ForHomepage'] == 2) {
            echo 'transform: scaleX(-1) !important;';
        } else {
            echo 'transform: none !important;';
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


<div class="cover desktop" id="loadDetector">
    <div class="cover-background" id="lowq-bg"></div>
    <div class="cover-background cover-background-2" id="highq-bg"></div>
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

                    <p>This page is your go-to place to find everything I do! There's a Gallery with all the 3D art I've
                        created, a Portfolio page with all the designs I've made, and a Projects page with all the
                        projects I've worked on over the years, such as Osekai, UNTONE ID, Cubey, and more!</p>

                    <p>On the left here is my character<small style="font-size: 60%; opacity: 0.5">fursona</small>
                        Tanza! I've modelled him over the past few years from scratch using Blender!
                        (https://blender.org). I'm constantly improving the model!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("work.html");
?>
<div class="cover mobile">
    <div class="cover-background"></div>
    <div class="cover-inner">
        <div class="home__cover-popup">
            <p>Hey, I'm <strong>Tanza</strong>!</p>
        </div>
        <div class="home__cover-textarea">
            <div class="home__cover-textarea-trim">
            </div>
            <div class="home__cover-textarea-inner">
                <h1>I create 3D models, websites, designs, games, apps, and more!</h1>

                <p>This page is your go-to place to find everything I do! There's a Gallery with all the 3D art I've
                    created, a Portfolio page with all the designs I've made, and a Projects page with all the
                    projects I've worked on over the years, such as Osekai, UNTONE ID, Cubey, and more!</p>

                <p>Up there is my character<small style="font-size: 60%; opacity: 0.5">fursona</small>
                    Tanza! I've modelled him over the past few years from scratch using Blender!
                    (https://blender.org). I'm constantly improving the model!</p>
            </div>
        </div>
    </div>
</div>

<div class="page-content" aload="home" loadelement="window">
    <div class="page-inner">
        <div class="home__panels" id="homepanelsarea">
            <div class="home__panels-left">
                <a hover="big" click="big" class="home__panel home__panel-large home__panel-gallery" href="/gallery">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-photo-video"></i></div>
                    <h1>Gallery</h1>
                    <?php
                    $image_wide = Database::execSimpleSelect("SELECT * FROM Gallery WHERE SimpleRatio = 'wide' ORDER BY Date DESC LIMIT 1");
                    $image_square = Database::execSimpleSelect("SELECT * FROM Gallery WHERE SimpleRatio = 'square' ORDER BY Date DESC LIMIT 1");
                    $image_tall = Database::execSimpleSelect("SELECT * FROM Gallery WHERE SimpleRatio = 'tall' ORDER BY Date DESC LIMIT 1");
                    ?>
                    <img loading="lazy" data-src="/img/gallery/thumbnail/<?= $image_wide[0]['Filename'] ?>"
                        class="lazy gallery-example-wide desktop">
                    <img loading="lazy" data-src="/img/gallery/thumbnail/<?= $image_square[0]['Filename'] ?>"
                        class="lazy gallery-example-square desktop">
                    <img loading="lazy" data-src="/img/gallery/thumbnail/<?= $image_tall[0]['Filename'] ?>"
                        class="lazy gallery-example-tall desktop">
                </a>
                <a hover="big" click="big" class="home__panel home__panel-large home__panel-portfolio" style="
                --col1: #2400FF;
                --col2: #0094FF;
                --col3: #2400FF;
                " href="/portfolio">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-layer-group"></i></div>
                    <h1>Portfolio</h1>
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

            </div>
            <div class="home__panels-right">
                <div hover="small" click="layer" class="home__panel home__panel-medium" style="
                --col1: #0066FF;
                --col2: #F042FF;
                --col3: #2400FF;
                " onclick="openLayer('layer_aboutme')">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-info-circle"></i></div>
                    <h1>About Me</h1>
                    <p>Learn all about me, my history, and my plans for the future!</p>
                </div>
                <div hover="small" click="layer" class="home__panel home__panel-medium" style="
                --col1: #8F00FF;
                --col2: #FF2F6D;
                --col3: #FF5C00;
                " onclick="openLayer('layer_refsheet')">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-paint-brush"></i></div>
                    <h1>Refsheet</h1>
                    <p>Check out my Protogen’s refsheet here! It’s super long!</p>
                </div>
                <div hover="small" click="layer" class="home__panel home__panel-medium" style="
                --col1: #FF007A;
                --col2: #9712FF;
                --col3: #0047FF;
                " onclick="openLayer('layer_contact')">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-envelope"></i></div>
                    <h1>Work / Contact</h1>
                    <p>Want some design work done? Contact me here!</p>
                </div>
                <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #6261E1;
                --col2: #469ACD;
                --col3: #43C3B8;
                " href="https://bsky.app/profile/tanza.me" target="_blank">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fas fa-box"></i></div>
                    <h1>Bluesky</h1>
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
<!--                 <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #5C4EE4;
                --col2: #4E78E4;
                --col3: #AB4EE4;
                " href="https://social.untone.uk/@tanza" target="_blank">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fab fa-mastodon"></i></div>
                    <h1>Mastodon</h1>
                </a> -->
                <a hover="smaller" click="normal" class="home__panel home__panel-small" style="
                --col1: #191C44;
                --col2: #161B22;
                --col3: #394049;
                " href="https://github.com/tanza3d" target="_blank">
                    <div class="home__panel-sheen desktop"></div>
                    <div class="icon"><i class="fab fa-github"></i></div>
                    <h1>Github</h1>
                </a>
            </div>
        </div>
    </div>   
</div>
<div class="page-content" aload="home" loadelement="window">
    <script src="https://platform.linkedin.com/badges/js/profile.js" async defer type="text/javascript"></script>
    <div class="badge-base LI-profile-badge" data-locale="en_US" data-size="large" data-theme="dark" data-type="HORIZONTAL" data-vanity="archie-williams-06171b190" data-version="v1"><a class="badge-base__link LI-simple-link" href="https://uk.linkedin.com/in/archie-williams-06171b190?trk=profile-badge"></a></div>
</div>           

<div class="layer layer-closed" id="layer_refsheet">
    <div class="layer__close-layer" onclick="closeLayer()"></div>
    <div class="layer__content">
        <div class="layer__header">
            <h1>Refsheet</h1>
            <i class="fas fa-times-circle" onclick="closeLayer()"></i>
        </div>
        <div class="layer-text-content">
            <p>This is the refsheet for Tanza! The colours can be a bit confusing. For more reference, please check <a
                    href="/gallery">the Gallery</a> for more references!</a>
                <img loading="lazy" src="/public/img/refsheet.png">
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
                <h1><strong>Tanza</strong>
                    <light>#6283</light>
                </h1>
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
            <p>The best way to contact me is through Discord. You can do so by adding me at Tanza#6283.</p>
            <p>If you would prefer, you can also commission a logo through <a
                    href="https://www.fiverr.com/hubzii/">Fiverr</a>!</a>
            <p>You can also send me an email at archie@untone.uk if that's preferred.</p>
        </div>
    </div>
</div>


<div class="layer layer-closed" id="layer_aboutme">
    <div class="layer__close-layer" onclick="closeLayer()"></div>
    <div class="layer__content">
        <div class="layer__header">
            <h1>About Me</h1>
            <i class="fas fa-times-circle" onclick="closeLayer()"></i>
        </div>
        <div class="layer-text-content">
            <h1>About</h1>
            <p>Hey, I’m Tanza! I was formerly known as Hubz, but recently switched over my name. I’m primarily a
                Developer and Designer, leading development on projects such as Osekai, Cubey, and more, and doing
                design for projects such as GTS, osu!, and more. To see the designs I’ve worked on, please check out <a
                    href="/portfolio">my Portfolio</a>! And for projects I actively lead or help out on, check out the
                <a href="/projects">Projects page!</a>
            </p>
            <p>On the side, I also enjoy 3d modelling, working on my Protogen scenes, and also various other characters
                like Sergals and others! I’m not that good at 3d modelling them yet, but I’m definitely getting better!
                If you’re interested in having a look at the 3D art I’ve made, have a look at my <a
                    href="/gallery">Gallery page</a>!</p>
            <p>Some other general info about me: I’m currently a minor, and I’m also gay. I think dragons are cute.
                Protogens are cool. And I’m taken by <a href="https://twitter.com/@ThatFlyingFurry">a cutie</a>
                (Dragonick) :3</p>

            <h1>History</h1>
            <p>A while ago, in August of 2021, I created a Protogen (Tanza), along with a new email, twitter account,
                and much more for it. I meant for this to be a completely separate account, and had no plans to link it
                to my, at the time, primary account (Hubz).</p>
            <p>I had been known as Hubz for most my life, joining Twitter under that username in 2017, Youtube in 2014,
                and getting a Gmail account under the username in 2013. The primary issue I had, is that at the time
                that account was quite professional. I was getting geared up to start accepting commissions, and I knew
                alot of people, so I had fears that just, well, “becoming a furry” there would have ended up with less
                people wanting to commission me, and some friends possibly even leaving due to it. So I instead created
                a brand new, separate account.</p>
            <p>Skip ahead a year, to August 2022, and late at night (2am), I made an impulse decision to rename my osu!
                account (at the time named Hubz) to Tanza3D, I did this, switched over my me! page, and went to sleep.
                The day after, I made tweets on both accounts talking about it, and linked the accounts together in
                their bios. This was somewhat of a scary moment for me, but no one seemed to mind that I was a furry,
                and things luckily carried on as usual!</p>
            <p>Over the coming months, I slowly renamed any accounts I had under Hubz to Tanza, such as my GitHub (Hubza
                > Tanza3D), Twitch (Hubzaa -> Tanza_Live), and more. I intended to keep two separate websites, Twitters,
                and Discords. One more oriented to the furry side, labelled as Tanza, and the the other oriented more to
                professional work, labeled as Hubz.</p>
            <p>Later on, I decided to finally completely remove the name Hubz from the picture, releasing a final album
                under the name labeled “A Final Goodbye.”, and afterwards abandoned the Hubz accounts, in some cases
                renaming them to Tanza, and in others just leaving them behind, as a kind of archive and legacy of my
                past. To this day, though, I still use two Discord accounts, both named Tanza, one for work and one for
                more personal usage. You can tell which one’s which, because the work one is always on DND!</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>

<script>
    var lazyLoadInstance = new LazyLoad({
        // Your custom settings go here
    });
</script>
