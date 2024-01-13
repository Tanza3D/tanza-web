function positionNav() {
    if (document.getElementsByClassName("navbar")[0] == undefined) return;
    navheight = document.getElementsByClassName("navbar")[0].clientHeight.toString();
    var body = document.body;
    let vh = window.innerHeight * 0.01;
    body.setAttribute("style", "--vh: " + vh + "px; --navbar-height: " + navheight + "px;");
}
positionNav();
window.onresize = positionNav;
window.onload = positionNav();



function closeLayer() {
    document.body.classList.remove("noscroll");
    var layers = document.getElementsByClassName("layer");
    for (var element of layers) {
        if (!element.classList.contains("layer-closed")) {
            element.classList.add("layer-closed");
        }
    }

}

function openLayer(id) {
    document.getElementById(id).classList.remove("layer-closed");
    document.body.classList.add("noscroll");
}

document.body.addEventListener('keypress', function(e) {
    if (e.key == "Escape") {
        closeLayer();
    }
});

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        closeLayer();
    }
}


function clone(obj) {
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    // Handle Date
    if (obj instanceof Date) {
        var copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        var copy = [];
        for (var i = 0, len = obj.length; i < len; i++) {
            copy[i] = clone(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        var copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

if (page != "home") {
    setCookie("do_load_anim", "false", 1);
}

var hrefs = document.querySelectorAll("[href]");
for (var element of hrefs) {
    console.log(element.tagName);
    if (element.tagName == "A" && element.getAttribute("target") != "_blank") {
        console.log(element);
        let link = element.getAttribute("href");
        element.classList.add("hovercursor");
    }
}

function insertParam(key, value, pushHistory = true) {
    if (!window.history.pushState) {
        return;
    }

    if (!key) {
        return;
    }

    var url = new URL(window.location.href);
    var params = new window.URLSearchParams(window.location.search);
    if (typeof value == 'undefined' || value === null) {

        params.delete(key);
    } else {
        params.set(key, value);
    }

    url.search = params;
    url = url.toString();
    if (pushHistory) {
        window.history.pushState({ url: url }, null, url);
    } else {
        window.history.replaceState({ url: url }, null, url);
    }
}

function getParam(key) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(key);
}

function removeParam(key) {
    if (!window.history.pushState || !key) {
        return;
    }

    var url = new URL(window.location.href);
    var params = new URLSearchParams(window.location.search);

    if (params.has(key)) {
        params.delete(key);
        url.search = params.toString();
        window.history.pushState({ url: url.toString() }, null, url.toString());
    }
}