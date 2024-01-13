<div class="cover cover-small">
    <h1>Portfolio</h1>
    <p>Designs I’ve worked on. Click on them to learn more!
    <p>
</div>

<div class="page-content" aload="basic" loadelement="window">
    <div class="page-inner">
        <div class="portfolio_section-picker">
            <div class="portfolio_section-button" id="button-branding" onclick="setActive('branding')">
                Branding
            </div>
            <div class="portfolio_section-button" id="button-web" onclick="setActive('web')">
                Web Design
            </div>
        </div>
        <div class="portfolio-page" id="page-branding">
            <div class="portfolio_left-content" id="portfolio-page">

            </div>
        </div>

        <div class="portfolio-page" id="page-web">
            <div class="portfolio_right-content" id="portfolio-page-web">
                <div id="web-left"></div>
                <div id="web-right"></div>
            </div>
        </div>

    </div>
</div>


<div class="layer layer-closed layer-portoflio" id="layer_info">
    <div class="layer__close-layer" onclick="closeLayer()"></div>
    <div class="layer__content">
        <div class="layer__header">
            <h1 id="name"></h1>
            <i class="fas fa-times-circle" onclick="closeLayer()"></i>
        </div>
        <div class="layer-text-content" id="layer_content">
            <p id="description"></p>
            <a class="button" id="websiteview">View website!</a>
            <div class="image-list" id="image-list"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>