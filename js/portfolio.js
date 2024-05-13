const pageEl = document.getElementById("portfolio-page");

function generatePortfolioPanel(item, largePopup = false, original = false) {
    var div = document.createElement("div");
    div.style = "--ratio: " + item["Ratio"].replace(":", "/");
    div.setAttribute("hover", "small")
    div.setAttribute("click", "layer")

    div.className = "portfolio-item";
    var img = document.createElement("img");
    img.classList.add("lazy");

    img.src = `/public/img/gallery/wide.png`;
    img.setAttribute("data-src", "/img/portfolio/" + item.Id + "/medium.png")
    if (original == true) {
        img.setAttribute("data-src", "/img/portfolio/" + item.Id + "/" + item.Images[0].path)
    }
    if(typeof(item['imageurl']) != "undefined") {
        img.setAttribute("data-src", item.imageurl);
    }

    img.src = `/public/img/gallery/${item['SimpleRatio']}.png`;
   
    div.appendChild(img);

    var title = document.createElement("h1");
    title.innerHTML = item['Name'];
    var description = document.createElement("h3");
    description.innerHTML = item['Description'];

    var overlay = document.createElement("div");
    overlay.classList.add("text-backdrop");
    div.appendChild(overlay);

    div.appendChild(title);
    div.appendChild(description);

    div.onclick = function () {
        openItem(item, largePopup)
    };


    if (parseInt(item.Id) == parseInt(window.location.hash.replace("#", ""))) {
        console.log("opening");
        openItem(item, largePopup)
    }

    return div;
}

async function DoRequest(method, url, data = null, headers = {}) {
    if (url == null) {
        url = method;
        method = "GET";
    }
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open(method, url);
        for (var header in headers) {
            xhr.setRequestHeader(header, headers[header]);
        }
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    resolve(resolve(JSON.parse(xhr.responseText, function (k, v) {
                        // Check if the value is an object
                        if (typeof v === "object" && v !== null) {
                            return v;  // Return the object as is
                        }

                        // Check if the value is a boolean (true or false)
                        if (v === true || v === false) {
                            return v;
                        }

                        // Check if the value is a non-numeric string
                        if (isNaN(v)) {
                            return v;  // Return the string as is
                        }

                        // Otherwise, parse the value as an integer
                        return parseInt(v, 10);
                    })));
                } catch {
                    resolve(resolve(xhr.responseText));
                }
            } else {
                reject({
                    status: xhr.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.onerror = function () {
            reject({
                status: xhr.status,
                statusText: xhr.statusText
            });
        };
        if (data) {
            var formData = new FormData();
            for (var key in data) {
                formData.append(key, data[key]);
            }
            xhr.send(formData);
        } else {
            xhr.send()
        }
    });
}

function loadPortfolio() {
    var xhr = new XMLHttpRequest();
    var url = "/api/portfolio/items";
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const filterTag = urlParams.get('filter')
    if (filterTag != null) {
        url = "/api/portfolio/items?filter=" + filterTag
    }
    xhr.open("GET", url);
    xhr.onload = async function () {
        var json = JSON.parse(xhr.responseText);

        var counter = 0;
        for (var item of json) {
            if (item.Website == "1") continue;
            item.Images = JSON.parse(item.Images);
        }



        var sorted = [];
        var section = [];

        var curAspect = 0;
        for (var item of json) {
            if (item.Website != "0") continue;
            section.push(item);

            let ratio = item['Ratio'].split(":");
            curAspect += (ratio[0] / ratio[1]);
            if (curAspect > 3) {
                curAspect = 0;
                sorted.push(section);
                section = [];
            }
        }
        console.log(sorted);


        for (var _section of sorted) {
            var sectionEl = document.createElement("div");
            sectionEl.className = "portfolio__row";
            for (item of _section) {
                if (_section.length == 1) {
                    sectionEl.appendChild(generatePortfolioPanel(item, false, true));
                } else {
                    sectionEl.appendChild(generatePortfolioPanel(item));
                }
            }
            pageEl.appendChild(sectionEl);
        }


        /// ! WEBSITEs
        var sectionElLeft = document.getElementById("web-left");
        var sectionElRight = document.getElementById("web-right");
        var current = "left";
        var leftHeight = 0;
        var rightHeight = 0;
        for (var item of json) {
            if (item.Website != "1") continue;
            item.Images = JSON.parse(item.Images);

            let ratio = item['Ratio'].split(":");
            var height = (ratio[1] / ratio[0]);

            if ((leftHeight + height) < (rightHeight + height)) {
                current = "left";
            } else {
                current = "right";
            }

            if (current == "left") {
                leftHeight += height;
                sectionElLeft.appendChild(generatePortfolioPanel(item, true));
            } else {
                rightHeight += height;
                sectionElRight.appendChild(generatePortfolioPanel(item, true));
            }



        }


        var covers = [];

        var moreCovers = await DoRequest("GET", "/api/portfolio/covers")

        for (var item of json) {
            if (item.Website == "2") covers.push(item)
        }
        for(var cover of moreCovers) covers.push(cover);

        console.log(covers);

        for (var cover of covers) {
            document.getElementById("portfolio-page-covers").appendChild(generatePortfolioPanel(cover, true));
        }


        var lazyLoadInstance = new LazyLoad({
            // Your custom settings go here
        });
    }
    xhr.send()
}
loadPortfolio();

function openItem(item, largePopup = false) {
    var layer = document.getElementById("layer_content");

    document.getElementById("name").innerHTML = item.Name;
    document.getElementById("description").innerHTML = item.Description;
    document.getElementById("image-list").innerHTML = "";
    if (largePopup) {
        layer.parentElement.parentElement.classList.add("large");
    } else {
        layer.parentElement.parentElement.classList.remove("large");
    }

    if (item.Link != "") {
        document.getElementById("websiteview").classList.remove("hidden-full");

        document.getElementById("websiteview").href = item.Link;
        document.getElementById("websiteview").innerHTML = "View website at <strong>" + item.Link.replace("https://", "") + "</strong>";
    } else {
        document.getElementById("websiteview").classList.add("hidden-full");
    }
    var imagecont = document.createElement("div");
    var counter = 0;
    var first = 2;
    for (var image of item.Images) {
        if (counter == 2 || first == 1) {
            first = 0;
            counter = 0;
            document.getElementById("image-list").appendChild(imagecont);
            var imagecont = document.createElement("div");
        }
        imagecont.className = "image-container";
        let imageElOuter = document.createElement("div");
        imageElOuter.classList.add("image-loading");
        imageElOuter.classList.add("image-outer");
        if (image.name != "undefined") {
            var text = document.createElement("h1");
            text.innerText = image.name;
            imageElOuter.appendChild(text);
        }
        let imageEl = document.createElement("img");
        imageEl.addEventListener("load", function () {
            imageElOuter.style = "--ratio: " + imageEl.clientWidth / imageEl.clientHeight
            imageElOuter.classList.remove("image-loading");
        });
        imageEl.src = "/img/portfolio/" + item.Id + "/" + image.path;
        if(image.path.startsWith("https")) {
            imageEl.src = image.path;
        }
        imageElOuter.appendChild(imageEl);
        imagecont.appendChild(imageElOuter);

        counter++;
        if (first == 2) first = 1;

    }

    document.getElementById("image-list").appendChild(imagecont);

    openLayer("layer_info");
}


function checkParams() {
    if (getParam("page") != null && getParam("page") == "web") {
        setActive("web", 0, false);
    }
    else if (getParam("page") != null && getParam("page") == "covers") {
        setActive("covers", 0, false);
    }
    else {
        setActive("branding", 0, false);
    }
}
checkParams();
window.addEventListener("popstate", checkParams);

function setActive(page, wait = 500, history = true) {
    if (page == "branding") {
        document.getElementById("button-branding").classList.add("active");
        document.getElementById("button-web").classList.remove("active");
        document.getElementById("button-covers").classList.remove("active");

        document.getElementById("page-web").classList.remove("active");
        document.getElementById("page-covers").classList.remove("active");
    }
    else if (page == "covers") {
        document.getElementById("button-branding").classList.remove("active");
        document.getElementById("button-web").classList.remove("active");
        document.getElementById("button-covers").classList.add("active");

        document.getElementById("page-branding").classList.remove("active");
        document.getElementById("page-web").classList.remove("active");
    }
    else {
        document.getElementById("button-branding").classList.remove("active");
        document.getElementById("button-covers").classList.remove("active");
        document.getElementById("button-web").classList.add("active");


        document.getElementById("page-branding").classList.remove("active");
        document.getElementById("page-covers").classList.remove("active");
    }

    setTimeout(() => {
        if (page == "branding") {
            document.getElementById("page-branding").classList.add("active");
        }
        else if (page == "covers") {
            document.getElementById("page-covers").classList.add("active");
        }
        else {
            document.getElementById("page-web").classList.add("active");
        }
    }, wait);

    if (history) {
        insertParam("page", page);
    }
}


checkParams();