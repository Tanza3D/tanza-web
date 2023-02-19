var projects = document.getElementById("projects");

var element = document.createElement("div");


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

projects.appendChild(element);
