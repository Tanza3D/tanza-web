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
            "big": "tz_sf_BigHover",
            "small": "tz_sf_SmallHover",
            "smaller": "tz_sf_SmallerHover",
        }, "hover", "small", function (el, file) {
            el.addEventListener("mouseover", function () {
                audioSystem.play(file);
            });
        });

        this.registerAudioDOM({
            "normal": "tz_sf_Click",
            "big": "tz_sf_TriumphantLoad"
        }, "click", "normal", function (el, file) {
            el.addEventListener("click", function () {
                audioSystem.play(file);
            });
        });

        this.registerAudioDOM({
            "home": "tz_sf_HomeLoad",
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