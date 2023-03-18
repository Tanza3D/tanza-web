var projectUploadItem = clone(projectPanelTemplate);

var editing = false;

function updatePreview() {
    document.getElementById("preview").innerHTML = "";

    document.getElementById("preview").appendChild(createProjectPanel(projectUploadItem));
}

function updateData() {
    projectUploadItem['date'] = new Date(document.getElementById("date").value);
    projectUploadItem['name'] = document.getElementById("name").value;
    projectUploadItem['badge'] = document.getElementById("badge").value;
    projectUploadItem['internalName'] = document.getElementById("internalName").value;
    projectUploadItem['description'] = document.getElementById("description").value;
    projectUploadItem['order'] = document.getElementById("order").value;

    var e = document.getElementById("size").value;
    projectUploadItem['size'] = e;
    if (document.getElementById("logo").files.length == 1) {
        projectUploadItem['logo'] = window.URL.createObjectURL(document.getElementById("logo").files[0])
    }
    if (document.getElementById("background").files.length == 1) {
        projectUploadItem['background'] = window.URL.createObjectURL(document.getElementById("background").files[0])
    }

    updatePreview();
}

function updateDataReverse() {
    document.getElementById("date").value = projectUploadItem['date'];
    document.getElementById("name").value = projectUploadItem['name'];
    document.getElementById("badge").value = projectUploadItem['badge'];
    document.getElementById("internalName").value = projectUploadItem['internalName'];
    document.getElementById("description").value = projectUploadItem['description'];
    document.getElementById("order").value = projectUploadItem['order'];
}

function toggleUploadModal(clean = true) {
    if (clean == true) 
    {
        projectUploadItem = null;
        projectUploadItem = clone(projectPanelTemplate);
        updateDataReverse();
        updatePreview();
    }

    if (editing) {
        for(item of document.querySelectorAll("[noshowineditor=\"\"]")) {
            item.classList.add("hidden");
        }
    } else {
        for(item of document.querySelectorAll("[noshowineditor=\"\"]")) {
            item.classList.remove("hidden");
        }
    }
    document.getElementById("upload-modal").classList.toggle("modal-hidden");
}

function uploadProject() {
    let xhr = new XMLHttpRequest();

    let formData = new FormData();
    if (editing == false) {
        if (document.getElementById("logo").files.length == 1) {
            formData.append("logo", document.getElementById("logo").files[0]);
        }
        if (document.getElementById("background").files.length == 1) {
            formData.append("background", document.getElementById("background").files[0]);
        }
    }

    formData.append("internalName", projectUploadItem.internalName);
    formData.append("name", projectUploadItem.name);
    formData.append("description", projectUploadItem.description);
    formData.append("badge", projectUploadItem.badge);
    formData.append("size", projectUploadItem.size);
    formData.append("order", projectUploadItem.order);
    formData.append("date", projectUploadItem.date.toISOString().slice(0, 19).replace('T', ' '));
    if (projectUploadItem.popupData.html == null) {
        formData.append("popupData", "link:" + projectUploadItem.popupData.link);
    } else {
        formData.append("popupData", "html:" + projectUploadItem.popupData.html);
    }

    xhr.onload = (event) => {
        toggleUploadModal();
        var response = JSON.parse(xhr.responseText);
    }
    if (editing) {
        xhr.open("POST", "/admin/api/projects/update");
    } else {
        xhr.open("POST", "/admin/api/projects/upload");
    }
    xhr.send(formData);
}

// ! EDITING

var col1 = document.getElementById("col_1");
var col2 = document.getElementById("col_2");

function loadProjects() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/projects/items");
    xhr.onload = function () {
        var json = JSON.parse(xhr.responseText);
        console.log(json);
        var clean = [];
        for (item of json) {
            clean.push(parseProject(item));
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

            var container = document.createElement("div");
            container.classList.add("project-panel__edit");
            var el = createProjectPanel(item);
            var controlbar = document.createElement("div");

            var editButton = document.createElement("div");
            editButton.innerHTML = "Edit";
            editButton.classList.add("button");
            editButton.addEventListener("click", function () {
                editing = true;
                console.log(item);
                projectUploadItem = item;
                toggleUploadModal(false);
                updateDataReverse();
                updatePreview();
            });
            controlbar.appendChild(editButton);
            controlbar.classList.add("project-panel__controlbar")

            container.appendChild(el);
            container.appendChild(controlbar);
            if (col == false) {
                col1.appendChild(container);
            } else {
                col2.appendChild(container);
            }
        }
    }
    xhr.send()
}
loadProjects();