var col1 = document.getElementById("projects_col1");
var col2 = document.getElementById("projects_col2");
var mobile = document.getElementById("projects_mobile");
/* var element = document.createElement("div");


var exampleDataBig = clone(projectPanelTemplate);
var exampleDataMedium = clone(projectPanelTemplate);
var exampleDataMediumCentered = clone(projectPanelTemplate);
var exampleDataSmall = clone(projectPanelTemplate);

exampleDataBig.size = "big";
exampleDataBig['internalName'] = "big boi";
exampleDataMedium.size = "medium";
exampleDataMedium['internalName'] = "medium boi";
exampleDataMediumCentered.size = "medium-centered";
exampleDataSmall.size = "small";

var big = createProjectPanel(exampleDataBig);
var medium = createProjectPanel(exampleDataMedium);
var mediumCentered = createProjectPanel(exampleDataMediumCentered);
var small = createProjectPanel(exampleDataSmall);


var header = document.createElement("p");
header.innerHTML = "big";
element.appendChild(header)
element.appendChild(big);

var header = document.createElement("p");
header.innerHTML = "medium";
element.appendChild(header)
element.appendChild(medium);

var header = document.createElement("p");
header.innerHTML = "medium-centered";
element.appendChild(header)
element.appendChild(mediumCentered);

var header = document.createElement("p");
header.innerHTML = "small";
element.appendChild(header)
element.appendChild(small);

element.style.width = "100%";

projects.appendChild(element); */


function loadProjects() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/projects/items");
    xhr.onload = function() {
        var json = JSON.parse(xhr.responseText);
        var clean = [];
        for (item of json) {
            clean.push(parseProject(item));
        }

        var numBig = 0;
        var numMedium = 0;
        var numSmall = 0;
        // 1 big = 1 medium = 2 small
        for (item of clean) {
            if (item['size'] == "big") {
                numBig += 1;
            }
            if (item['size'] == "medium" || item['size'] == "medium-centered") {
                numMedium += 1;
            }
            if (item['size'] == "small") {
                numSmall += 1;
            }
        }

        var trackBig = false;
        var trackMedium = false;
        var trackSmall = false;

        for (let item of clean) {
            var col = false; // false = left, true = right
            if (item['size'] == "big") {
                col = trackBig;
                trackBig = !trackBig;
            }
            if (item['size'] == "medium" || item['size'] == "medium-centered") {
                if (trackBig == false) {
                    trackMedium = true;
                    trackBig = true;
                }
                col = trackMedium;
                if (!item['internalName'].includes("cubey")) {
                    // ? gotta keep those cubey's together
                    trackMedium = !trackMedium;
                }
            }
            if (item['size'] == "small") {
                if (trackBig == true) trackSmall = true;
                col = trackSmall;
                trackSmall = !trackSmall;
            }

            var el = createProjectPanel(item);
            var el2 = createProjectPanel(item);
            if (col == false) {
                col1.appendChild(el);
            } else {
                col2.appendChild(el);
            }
            el.onclick = function() {
                openProjectsPopup(item);
            }
            el2.onclick = function() {
                openProjectsPopup(item);
            }
            mobile.appendChild(el2); // have to do this twice.. :/
            
            // TODO: don't

            console.log("column: " + col);
        }
    }
    xhr.send()
}

function openProjectsPopup(item) {
    if (item['popupData'].startsWith("link:")) {
        window.open(item['popupData'].replace("link:", ""), '_blank').focus();
    } else {
        item = cleanData(item); // the background does not exist, for some reason, if you don't do this
        console.log(item);
        document.getElementById("layer_info").style = `--background: url("${item['background']}")`
        document.getElementById("layer_logo").src = item['logo'];
        document.getElementById("layer_name").innerHTML = item['name'];
        document.getElementById("layer_description").innerHTML = item['description'];
        document.getElementById("layer_content").innerHTML = item['popupData'].replace("html:", "");
        openLayer('layer_info')
    }
}
loadProjects();