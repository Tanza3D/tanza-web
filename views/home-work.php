<div class="home__work">
    <div class="home__work-top">
        <div class="home__work-top-left">
            <img src="/public/img/work.png"></img>
        </div>
        <div class="home__work-top-right">
            <h1>Hi, I’m <strong>Archie Williams</strong></h1>
            <h3>I’m a professional UI/UX Designer and Web Developer</h3>
            <p>I'm a UI/UX Designer and Programmer. I've been doing programming for 5 years or so now, and UI/UX design
                for 6 if not more!</p>

            <p>Most of my work is done on a volunteer basis on community projects or other small projects.</p>

            <p>I've done official designs for osu! (https://osu.ppy.sh), and also worked on Osekai, GTS, and more. I've
                also worked on various design projects for tournaments and events, and have also created various brand
                designs.</p>

            <div class="home__work-buttons">
                <a href="/past_work" class="button">Past Work</a>
                <a href="/projects" class="button">Projects</a>
                <a href="/portfolio" class="button">Portfolio</a>
                <a href="/public/cv.pdf" class="button button-solid" target="_blank">Download CV</a>
            </div>
        </div>
    </div>
    <div class="home__work-carousel">
        <div class="home__work-carousel-title">
            <h1>Portfolio</h1>
            <a href="/portfolio">View More</a>
        </div>
        <div class="home__work-carousel-inner">
            <div class="home__work-carousel-inner-maxw">
                <?php
                $portfolios = Database::execSimpleSelect("SELECT * FROM Portfolio WHERE website = 0 ORDER BY Date DESC LIMIT 15");
                shuffle($portfolios);
                foreach ($portfolios as $portfolio) {
                    $images = json_decode($portfolio['Images'], true);
                    echo '<a href="/portfolio#' . $portfolio['Id'] . '"><img loading="lazy" class="lazy carousel-image" data-src="/img/portfolio/' . $portfolio['Id'] . '/small.png"></a>';
                }
                foreach ($portfolios as $portfolio) {
                    $images = json_decode($portfolio['Images'], true);
                    echo '<a href="/portfolio#' . $portfolio['Id'] . '"><img loading="lazy" class="lazy carousel-image" data-src="/img/portfolio/' . $portfolio['Id'] . '/small.png"></a>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="home__work-footer">
        <div class="home__work-footer-left">
            <p>(C) Archie Williams / Tanza</p>
            <a href="https://github.com/Tanza3D/tanza-web/">This site is open source!</a>
        </div>
        <div class="home__work-footer-right">
            <a href="https://bsky.app/profile/tanza.me"><i class="fas fa-square"></i></a>
            <a href="https://www.linkedin.com/in/archie-"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>

<script>
    var lazyLoadInstance = new LazyLoad({
        // Your custom settings go here
    });
</script>