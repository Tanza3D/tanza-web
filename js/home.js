var homepanels = document.querySelectorAll(`.home__panel`);
for(var x = 0; x < homepanels.length; x++) {
    homepanels[x].addEventListener("animationend", function(el) {
        el.target.style.opacity = "1";
        el.target.classList.add("home__panel-finished");
    }, false);
}

function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top / 1.5 >= 0 &&
        rect.left / 1.5 >= 0 &&
        rect.bottom / 1.5 <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right / 1.5 <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function checkScroll() {
    if(isInViewport(document.getElementById("homepanelsarea"))) {
        for(var x = 0; x < homepanels.length; x++) {
            homepanels[x].classList.add("home__panel-animate");
        }
    }
}

document.addEventListener('scroll', function () {
    checkScroll();
});
checkScroll();

document.addEventListener("load", function() {
    checkScroll();
});