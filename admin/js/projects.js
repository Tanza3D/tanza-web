var projectUploadItem = clone(projectPanelTemplate);

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

function toggleUploadModal() {
    document.getElementById("upload-modal").classList.toggle("modal-hidden");
}

function uploadProject() {
    let xhr = new XMLHttpRequest();

    let formData = new FormData();
    if (document.getElementById("logo").files.length == 1) {
        formData.append("logo", document.getElementById("logo").files[0]);
    }
    if (document.getElementById("background").files.length == 1) {
        formData.append("background", document.getElementById("background").files[0]);
    }
    
    formData.append("internalName", projectUploadItem.internalName);
    formData.append("name", projectUploadItem.name);
    formData.append("description", projectUploadItem.description);
    formData.append("badge", projectUploadItem.badge);
    formData.append("size", projectUploadItem.size);
    formData.append("order", projectUploadItem.order);
    formData.append("date", projectUploadItem.date.toISOString().slice(0, 19).replace('T', ' '));
    if(projectUploadItem.popupData.html == null) {
        formData.append("popupData", "link:"+projectUploadItem.popupData.link);
    } else {
        formData.append("popupData", "html:"+projectUploadItem.popupData.html);
    }

    xhr.onload = (event) => {
        var response = JSON.parse(xhr.responseText);
        
    }

    xhr.open("POST", "/admin/api/projects/upload");
    xhr.send(formData);
}