var baseItem = {
    name: "",
    description: "",
    date: "",
    images: [],
    imageDescriptions: [],
    link: ""
}

var portfolioUploadItem = clone(baseItem);

var editing = false;

function updateData() {
    portfolioUploadItem['name'] = document.getElementById("name").value;
    portfolioUploadItem['description'] = document.getElementById("description").value;
    portfolioUploadItem['date'] = document.getElementById("date_up").value;
    portfolioUploadItem['link'] = document.getElementById("link").value;
    if (portfolioUploadItem['images'].length == 0) {
        var parent = document.getElementById("image-grid");
        while (parent.firstChild) {
            parent.firstChild.remove()
        }
    }
    // TODO: images
}

function updateDataReverse() {
    document.getElementById("name").value = portfolioUploadItem['name'];
    document.getElementById("description").value = portfolioUploadItem['description'];
    document.getElementById("date_up").value = portfolioUploadItem['date'];
    document.getElementById("link").value = portfolioUploadItem['link'];

    // fuck you i can't be arsed to implement image editing
}

function toggleUploadModal(clean = true) {
    if (clean == true) {
        portfolioUploadItem = null;
        portfolioUploadItem = clone(baseItem);
        updateDataReverse();
    }

    if (editing) {
        for (item of document.querySelectorAll("[noshowineditor=\"\"]")) {
            item.classList.add("hidden");
        }
    } else {
        for (item of document.querySelectorAll("[noshowineditor=\"\"]")) {
            item.classList.remove("hidden");
        }
    }
    document.getElementById("upload-modal").classList.toggle("modal-hidden");
}

function removeItemAll(arr, value) {
    var i = 0;
    while (i < arr.length) {
        if (arr[i] === value) {
            arr.splice(i, 1);
        } else {
            ++i;
        }
    }
    return arr;
}

function uploadProject() {
    let xhr = new XMLHttpRequest();

    let formData = new FormData();


    formData.append("name", portfolioUploadItem.name);
    formData.append("description", portfolioUploadItem.description);
    formData.append("date", portfolioUploadItem.date);
    formData.append("link", portfolioUploadItem.link);
    if (editing == false) {
        //formData.append("logo", document.getElementById("logo").files[0]);
        var dumdum = 0;
        for (var file of portfolioUploadItem.images) {
            formData.append("image" + dumdum, file);
            formData.append("imagedesc" + dumdum, portfolioUploadItem.imageDescriptions[dumdum]);
            dumdum++;
        }
    }
    // TODO: images

    xhr.onload = (event) => {
        toggleUploadModal();
        var response = JSON.parse(xhr.responseText);
    }
    if (editing) {
        xhr.open("POST", "/admin/api/portfolio/update");
    } else {
        xhr.open("POST", "/admin/api/portfolio/upload");
    }
    xhr.send(formData);
}

function dropHandler(ev) {
    console.log("File(s) dropped");

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();

    if (ev.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        [...ev.dataTransfer.items].forEach((item, i) => {
            // If dropped items aren't files, reject them
            if (item.kind === "file") {
                const file = item.getAsFile();
                portfolioUploadItem.images.push(file);

                console.log(`:3 … file[${i}].name = ${file.name}`);

                console.log("setting date");
                const update = new Date(file.lastModified);
                document.getElementById("date_up").value = update.toISOString().slice(0, 16);

                let imgContainer = document.createElement("div");

                let img = document.createElement("img");
                img.src = window.URL.createObjectURL(file);

                let input = document.createElement("input");
                input.type = "text";
                input.onchange = function() {
                    portfolioUploadItem.imageDescriptions[portfolioUploadItem.images.indexOf(file)] = input.value;
                }

                let remove = document.createElement("div");
                remove.innerHTML = "remove";
                remove.className = "button";

                remove.onclick = function() {
                    portfolioUploadItem.imageDescriptions = removeItemAll(portfolioUploadItem.imageDescriptions, portfolioUploadItem.imageDescriptions[portfolioUploadItem.images.indexOf(file)]);
                    portfolioUploadItem.images = removeItemAll(portfolioUploadItem.images, file);
                    imgContainer.remove();
                }
                imgContainer.appendChild(img);
                imgContainer.appendChild(input);
                imgContainer.appendChild(remove);

                document.getElementById("image-grid").appendChild(imgContainer);

            }
        });
    } else {
        // Use DataTransfer interface to access the file(s)
        [...ev.dataTransfer.files].forEach((file, i) => {
            console.log(`… file[${i}].name = ${file.name}`);
        });
    }
}


function dragOverHandler(ev) {
    console.log("File(s) in drop zone");

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();
}


// ! EDITING

function loadProjects() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/portfolio/items");
    xhr.onload = function() {
        var json = JSON.parse(xhr.responseText);
        for (let item of json) {
            // TODO: UI
        }
    }
    xhr.send()
}

loadProjects();