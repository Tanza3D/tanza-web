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

function parseProject(item) {
    var newItem = clone(projectPanelTemplate);
    newItem.internalName = item['InternalName'];
    newItem.name = item['Name'];
    newItem.description = item['Description'];
    newItem.background = item['Background'];
    newItem.logo = item['Logo'];
    newItem.badge = item['Badge'];
    newItem.popupData = {};
    if(item['Popup'].startsWith("link:")) {
        newItem.popupData = {
            "link": item['Popup'].replace("link:", "")
        }
    } else {
        newItem.popupData = {
            "html": item['Popup'].replace("html:", "")
        }
    }
    newItem.size = item['Size'];
    newItem.date = item['Date'];
    newItem.order = item['Order'];
    return newItem;
}

function loadProjects() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/projects/items");
    xhr.onload = function() {
        var json = JSON.parse(xhr.responseText);
        console.log(json);
        var clean = [];
        for(item of json) {
            clean.push(parseProject(item));
        }

        var numBig = 0;
        var numMedium = 0;
        var numSmall = 0;
        // 1 big = 1 medium = 2 small
        for (item of clean) {
            if(item['size'] == "big") {
                numBig += 1;
            }
            if(item['size'] == "medium" || item['size'] == "medium-centered") {
                numMedium += 1;
            }
            if(item['size'] == "small") {
                numSmall += 1;
            }
        }

        var trackBig = false;
        var trackMedium = false;
        var trackSmall = false;

        for (item of clean) {
            var col = false; // false = left, true = right
            if(item['size'] == "big") {
                col = trackBig;
                trackBig = !trackBig;
            }
            if(item['size'] == "medium" || item['size'] == "medium-centered") {
                if(trackBig == false) {
                    trackMedium = true;
                    trackBig = true;
                }
                col = trackMedium;
                if(!item['internalName'].includes("cubey")) {
                    // ? gotta keep those cubey's together
                    trackMedium = !trackMedium;
                }
            }
            if(item['size'] == "small") {
                if(trackBig == true) trackSmall = true;
                col = trackSmall;
                trackSmall = !trackSmall;
            }

            var el = createProjectPanel(item);
            if(col == false) {
                col1.appendChild(el);
            } else {
                col2.appendChild(el);
            }
            mobile.appendChild(createProjectPanel(item)); // have to do this twice.. :/
            // TODO: don't

            console.log("column: " + col);
        }
    }
    xhr.send()
}
loadProjects();