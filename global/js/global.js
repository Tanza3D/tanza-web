function positionNav() {
    if (document.getElementsByClassName("navbar")[0] == undefined) return;
    navheight = document.getElementsByClassName("navbar")[0].clientHeight.toString();
    var body = document.body;
    body.setAttribute("style", "--navbar-height: " + navheight + "px;");
}
positionNav();
window.onresize = positionNav;
window.onload = positionNav();

window.addEventListener("load", function () {
    document.body.classList.add("loaded");
})


var audioSystem = {
    play: function (file) {
        var audio = new Audio('/public/audio/' + file + ".mp3");
        audio.play();
    },
    registerAudioDOM: function (files, attribute, defaultFile, callback) {
        var all = document.querySelectorAll(`[${attribute}]`);
        for (var x = 0; x < all.length; x++) {
            var attr = all[x].getAttribute(attribute);
            if (attr == null) {
                attr = defaultFile;
            }
            callback(all[x], files[attr]);
        }
    },
    registerAudios: function () {
        this.registerAudioDOM({
            "big": "tr_tz_sf_BigHover",
            "small": "tr_tz_sf_SmallHover",
            "smaller": "tr_tz_sf_SmallerHover"
        }, "hover", "small", function (el, file) {
            el.addEventListener("mouseover", function () {
                audioSystem.play(file);
            });
        });

        this.registerAudioDOM({
            "normal": "tr_tz_sf_Click",
            "big": "tr_tz_sf_TriumphantLoad",
            "layer": "tr_tz_sf_LayerOpen"
        }, "click", "normal", function (el, file) {
            el.addEventListener("click", function () {
                audioSystem.play(file);
            });
        });

        this.registerAudioDOM({
            "home": "tr_tz_sf_HomeLoad",
        }, "aload", "home", function (el, file) {
            if (el.getAttribute("loadelement") == "window") {
                window.addEventListener("load", function () {
                    audioSystem.play(file);
                });
            } else {
                el.addEventListener("load", function () {
                    audioSystem.play(file);
                });
            }
        });
    }
}
audioSystem.registerAudios();

function closeLayer() {
    document.body.classList.remove("noscroll");
    var layers = document.getElementsByClassName("layer");
    for (var element of layers) {
        if (!element.classList.contains("layer-closed")) {
            element.classList.add("layer-closed");
            audioSystem.play("tr_tz_sf_LayerClose"); // this has to be done in here, because this function can be called when hitting ESC even if there's none open
        }
    }

}
function openLayer(id) {
    document.getElementById(id).classList.remove("layer-closed");
    document.body.classList.add("noscroll");
}

document.body.addEventListener('keypress', function (e) {
    if (e.key == "Escape") {
        closeLayer();
    }
});