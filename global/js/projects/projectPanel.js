// data example
projectPanelTemplate = {
    "internalName": "project-name",
    "name": "Project Name",
    "description": "",
    "background": "/public/img/projects/noBackground.jpg", // ? optional, shouldn't be used beyond admin
    "logo": "no logo?", // ! needs to be set, else it won't know what format the logo is in. background is always jpg (converted)
    "badge": "OWN", // ? preset to "OWN",
    "imageTypes": "link", // ? set to "link" by default, should not be set unless through admin panel (b64 images)
    "popupData": {
        "html": null,
        // ! OR
        "link": "/" // * redirects to osekai.net when clicking, instead of popup
    },
    "size": "big",
    "date": new Date(),
    "order": 0
}


function cleanDataDirect(data) {
    var finalData = projectPanelTemplate;

    if(data['internalName'] != undefined) finalData['internalName'] = data['internalName'];
    else return {"error":"Internal Name not set"};

    if(data['name'] != undefined) finalData['name'] = data['name'];
    else return {"error":"Name not set"};

    if(data['logo'] != undefined) finalData['logo'] = data['logo'];
    else return {"error":"Logo not set"};

    if(data['description'] != undefined) finalData['description'] = data['description'];
    else return {"error":"Description not set"};

    if(data['badge'] != undefined) finalData['badge'] = data['badge'];
    if(data['imageTypes'] != undefined) finalData['imageTypes'] = data['imageTypes'];
    if(data['size'] != undefined) finalData['size'] = data['size'];

    if(data['popupData']['html'] != undefined) {
        // we're using html :D
        finalData['popupData']['html'] = data['popupData']['html'];
        delete finalData['popupData']['link']; 
    } else {
        if(data['popupData']['link'] != undefined) {
            finalData['popupData']['link'] = data['popupData']['link'];
            delete finalData['popupData']['html']; 
        } else {
            return {"error":"Link or Html in popupData is not set"};
        }
    }

    if(data['background'] != undefined && data['background'] != "") finalData['background'] = data['background'];
    else finalData['background'] = `/img/projects/${finalData['internalName']}/background.jpg`;

    return finalData;
}

function cleanData(data) {
    var response = cleanDataDirect(data);
    if(response['error'] != undefined) {
        console.error(response['error']);
        return null;
    } else {
        return response;
    }
}

function createProjectPanel(data) {
    data = cleanData(data);
    console.log(data);

    var element = document.createElement("div");
    element.classList.add("project-panel");
    element.classList.add(`project-panel__${data['size']}`);
    element.style = `--background: url("${data['background']}");`

    var badgeEl = document.createElement("div");
    badgeEl.classList.add("project-panel__badge");
    badgeEl.innerHTML = data['badge'];

    if(data['logo'].includes("/img/") || data['logo'].includes("blob")) {
        var logo = document.createElement("img");
        logo.src = data['logo'];
    } else {
        var logo = document.createElement("h3");
        logo.innerHTML = logo;
        console.log("If 'logo' url displayed not expected, use absolute url to image.");
    }
    
    var text = document.createElement("p");
    text.innerHTML = data['description'];

    element.appendChild(badgeEl);
    element.appendChild(logo);
    element.appendChild(text);

    return element;
}