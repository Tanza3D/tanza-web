var pictures = document.getElementById("gallery-pictures");
var sidebar = document.getElementById("gallery-sidebar");

var imageCounts = {};
var alreadyBig = false;

function loadProjects() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/gallery/webitems");
    xhr.onload = function() {
        var json = JSON.parse(xhr.responseText);
        console.log(json);
        for (var items of json) {
            var row = document.createElement("div");

            row.classList.add("item-batch");
            if (items.length == 1) row.classList.add("item-batch-single")
            else row.classList.add("item-batch-double");

            for (let image of items) {
                let date = new Date(image['Date']);

                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                let day = date.getDate();
                // this is kinda dumb
                if (imageCounts["y" + year] == undefined) {
                    imageCounts["y" + year] = {};
                    imageCounts["y" + year]['count'] = 0;
                    imageCounts["y" + year]['name'] = year;
                }
                if (imageCounts["y" + year]["m" + month] == undefined) {
                    imageCounts["y" + year]["m" + month] = {};
                    imageCounts["y" + year]["m" + month]['count'] = 0;
                    imageCounts["y" + year]["m" + month]['name'] = month;
                }
                imageCounts["y" + year]['count'] += 1;
                imageCounts["y" + year]["m" + month]['count'] += 1;
                let ratio = image['Ratio'].split(":");
                let item = document.createElement("div");
                let dimage = document.createElement("img");

                item.setAttribute("year", "y" + year);
                item.setAttribute("month", "m" + month);
                item.setAttribute("filename", image['Filename']);

                item.setAttribute("hover", "small")
                item.setAttribute("click", "layer")

                item.style = `--ratio: ${ratio[0]}/${ratio[1]}`;
                item.classList.add("item");

                dimage.classList.add("lazy");
                dimage.classList.add("gallery-imgel");
                dimage.src = `/public/img/gallery/${image['SimpleRatio']}.png`;
                if (items.length == 1 && alreadyBig == false) {
                    alreadyBig = true;
                    dimage.setAttribute("data-src", `/img/gallery/original/${image['Filename']}`)
                } else {
                    dimage.setAttribute("data-src", `/img/gallery/small/${image['Filename']}`)
                }

                let overlay = document.createElement("div");
                overlay.classList.add("item-overlay")
                let header = document.createElement("h2");
                let description = document.createElement("h3");
                let edate = document.createElement("p");
                edate.innerHTML = date.toLocaleString('en', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });;
                header.innerHTML = image['Name'];
                description.innerHTML = image['Description'];
                overlay.appendChild(header);

                overlay.appendChild(edate);
                overlay.appendChild(description);

                item.appendChild(dimage);
                item.appendChild(overlay);
                row.appendChild(item);

                item.onclick = function() {
                    document.getElementById("ip-title").innerHTML = image['Name'];
                    document.getElementById("ip-date").innerHTML = date.toLocaleString('en', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric',
                    });;
                    document.getElementById("ip-description").innerHTML = image['Description'];
                    document.getElementById("image-popup").classList.remove("image-popup-hidden");
                    document.getElementById("ip-bg").src = `/img/gallery/small/${image['Filename']}`;
                    document.getElementById("ip-mi").src = `/img/gallery/original/${image['Filename']}`;

                    document.getElementById("ip-mi").classList.add("imgload-hidden");

                }
            }
            pictures.appendChild(row);
        }
        generateSidebar();
        var lazyLoadInstance = new LazyLoad({
            // Your custom settings go here
        });
        audioSystem.registerAudios();
    }
    xhr.send()
}

function closePopup() {
    document.getElementById("image-popup").classList.add("image-popup-hidden");
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        closePopup();
    }
}

// this is dumb
var monthNames = [
    'January', 'February', 'March', 'April', 'May',
    'June', 'July', 'August', 'September',
    'October', 'November', 'December'
];

function doScrollTo(element) {
    console.log(element);
    const y = element.getBoundingClientRect().top + window.pageYOffset - 40;
    window.scrollTo({ top: y, behavior: 'smooth' });
}

function generateSidebar() {
    for (const [key, value] of Object.entries(imageCounts)) {
        console.log(year);
        var year = document.createElement("div");
        year.classList.add("sidebar-year");
        year.setAttribute("sidebar-year", key)
        var year_h1 = document.createElement("h1");
        year_h1.innerHTML = value['name'];
        year.appendChild(year_h1);

        var months = document.createElement("div");
        months.classList.add("sidebar-year-months");
        for (const [xkey, xvalue] of Object.entries(value)) {
            if (xvalue['name'] == undefined) continue;
            var month = document.createElement("div");
            month.classList = "sidebar-year-month";
            month.setAttribute("sidebar-month", xkey);
            var monthName = document.createElement("p");
            var monthCount = document.createElement("span");

            monthName.innerHTML = monthNames[parseInt(xvalue['name'] - 1)];
            monthCount.innerHTML = xvalue['count'];
            month.appendChild(monthName);
            month.appendChild(monthCount);
            months.appendChild(month);
            month.setAttribute("click", "slide")
            month.onclick = function() {
                const element = document.querySelector(`[month=${xkey}][year=${key}]`);
                doScrollTo(element);
            }
        }
        year.appendChild(months);

        year_h1.setAttribute("click", "slide")
        year_h1.onclick = function() {
            const element = document.querySelector(`[year=${key}]`);
            doScrollTo(element);
        }
        sidebar.appendChild(year);
    }
    audioSystem.registerAudios();
}
loadProjects();

function getMostVisibleElement(els) {
    var viewportHeight = window.innerHeight

    var maxtop = 999999999;
    var mostVisibleEl = null

    for (var el of Array.from(els)) {
        var viewportOffset = el.getBoundingClientRect();
        // these are relative to the viewport, i.e. the window
        var top = viewportOffset.top - 60;
        /* console.log("top: " + top); */
        /* console.log("offsetHeight: " + el.offsetHeight) */
        var left = viewportOffset.left;
        if (top < maxtop && top > (0 - (el.offsetHeight - (viewportHeight / 3)))) {
            /* console.log("smaller"); */
            mostVisibleEl = el;
            maxtop = top;
        }
    }

    return mostVisibleEl;
}



function calcVisible() {
    var visible = getMostVisibleElement(document.getElementsByClassName("item"));
    if (visible != null) {
        var visible_month = visible.getAttribute("month");
        var visible_year = visible.getAttribute("year");

        if (document.getElementsByClassName("sidebar-year-active")[0] != undefined && document.getElementsByClassName("sidebar-year-month-active")[0] != undefined) {
            var curac_year = document.getElementsByClassName("sidebar-year-active")[0];
            var curac_month = document.getElementsByClassName("sidebar-year-month-active")[0];
            if (curac_year.getAttribute("sidebar-year") != visible_year) {
                curac_year.classList.remove("sidebar-year-active");
            }
            if (curac_month.getAttribute("sidebar-month") != visible_month) {
                curac_month.classList.remove("sidebar-year-month-active");
            }
        }
        var yearel = document.querySelector("[sidebar-year=" + visible_year + "]");
        yearel.classList.add("sidebar-year-active")
        var monthel = yearel.querySelector("[sidebar-month=" + visible_month + "]");
        monthel.classList.add("sidebar-year-month-active")
        console.log(monthel.getBoundingClientRect().top);
        document.getElementById("gallery-sidebar").scrollTop = monthel.offsetTop - document.getElementById("gallery-sidebar").clientHeight / 2;
    }
}

document.onscroll = function() {
    calcVisible();
}

document.getElementById("ip-mi").onload = function() {
    document.getElementById("ip-mi").classList.remove("imgload-hidden");
}