function positionNav() {
    navheight = document.getElementsByClassName("navbar")[0].clientHeight.toString();
    var body = document.body;
    body.setAttribute("style", "--navbar-height: " + navheight + "px;");
}
positionNav();
window.onresize = positionNav;
window.onload = positionNav();