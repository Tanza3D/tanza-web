var items = [];

function loadGallery() {
    const req = new XMLHttpRequest();
    req.addEventListener("load", function() {
        items = JSON.parse(req.responseText)
        html = "";
        for (var x = 0; x < items.length; x++) {
            var item = items[x];
            html += `<div class="gallery__item" gallery-id="${item.Id}" selector="gallery-item">
            <img src="/img/gallery/thumbnail/${item.Filename}" style="aspect-ratio: ${item.Ratio.replace(":", "/")};">
            <div class="gallery__item-options">
                <div class="gallery__item-info">
                    <h3 selector="name">${item.Name}</h3>
                    <p selector="info">${item.Date} <span>/ ${item.Filename}</span> <strong>${item.Tags}</strong></p>
                    <small selector="description">${item.Description}</small>
                </div>
                <div class="gallery__item-controls hidden">
                    /* TODO: fix this inline style shit */
                    <div style="display: flex;">
                        <div>
                            <p>Name</p>
                            <input type="text" selector="edit-name" value="${quoteattr(item.Name)}">
                            <p>Tags</p>
                            <input type="text" selector="edit-tags" value="${quoteattr(item.Tags)}">
                            <p>Date</p>
                            <input type="datetime-local" selector="edit-date" value="${quoteattr(item.Date)}">
                        </div>
                        <div style="margin-left: 10px;">
                            <p>Description</p>
                            <textarea rows="3" selector="edit-description" id="edit_1671300616_description">${item.Description}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gallery__item-buttons-info">
                <div class="button" selector="edit-button">Edit</div>
            </div>
            <div class="gallery__item-buttons-edit hidden">
                <div class="button" selector="cancel-button">Cancel</div>
                <div class="button" selector="save-button">Save</div>
            </div>
        </div>`;
        }
        document.getElementById("gallery-list").innerHTML = html;

        var domitems = document.querySelectorAll("[selector='gallery-item']");
        console.log(domitems);
        for (var y = 0; y < domitems.length; y++) {
            let item = domitems[y];
            let referencedItem = null;
            for (var x = 0; x < items.length; x++) {
                if (items[x].Id == item.getAttribute("gallery-id")) {
                    referencedItem = items[x];
                }
            }
            if (referencedItem == null) {
                console.log("could not find referenced art item for id " + item.getAttribute("gallery-id"));
                continue
            };
            let updateData = function(galleryItem) {
                console.log("updating data");

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/admin/api/gallery/update", true);

                var fd = new FormData();
                fd.append("Date", galleryItem.Date);
                fd.append("Name", galleryItem.Name);
                fd.append("Description", galleryItem.Description);
                fd.append("Tags", galleryItem.Tags);
                fd.append("Id", galleryItem.Id);

                xhr.send(fd);

                item.querySelector("[selector='edit-description']").innerHTML = galleryItem.Description;
                item.querySelector("[selector='edit-name']").value = galleryItem.Name;
                item.querySelector("[selector='edit-tags']").value = galleryItem.Tags;
                item.querySelector("[selector='edit-date']").value = galleryItem.Date;

                item.querySelector("[selector='name']").innerHTML = galleryItem.Name;
                item.querySelector("[selector='info']").innerHTML = `${galleryItem.Date} <span>/ ${galleryItem.Filename}</span> <strong>${galleryItem.Tags}</strong>`;
                item.querySelector("[selector='description']").innerHTML = galleryItem.Description;
            }

            let beginEdit = function() {
                item.classList.add("gallery__item-editing");
                item.querySelector(".gallery__item-controls").classList.remove("hidden");
                item.querySelector(".gallery__item-buttons-edit").classList.remove("hidden");
                item.querySelector(".gallery__item-info").classList.add("hidden");
                item.querySelector(".gallery__item-buttons-info").classList.add("hidden");
            }
            let finishEdit = function(refitem) {
                item.classList.remove("gallery__item-editing");
                item.querySelector(".gallery__item-controls").classList.add("hidden");
                item.querySelector(".gallery__item-buttons-edit").classList.add("hidden");
                item.querySelector(".gallery__item-info").classList.remove("hidden");
                item.querySelector(".gallery__item-buttons-info").classList.remove("hidden");

                updateData(refitem);
            }
            item.querySelector("[selector='edit-button']").addEventListener("click", (event) => {
                beginEdit();
            });
            item.querySelector("[selector='save-button']").addEventListener("click", (event) => {
                referencedItem.Tags = item.querySelector("[selector='edit-tags']").value;
                referencedItem.Name = item.querySelector("[selector='edit-name']").value;
                referencedItem.Date = item.querySelector("[selector='edit-date']").value;
                referencedItem.Description = item.querySelector("[selector='edit-description']").value;
                console.log(referencedItem);
                finishEdit(referencedItem);
            });
            item.querySelector("[selector='cancel-button']").addEventListener("click", (event) => {
                finishEdit(referencedItem);
                item.querySelector("[selector='edit-description']").value = galleryItem.Description;
                item.querySelector("[selector='edit-name']").value = galleryItem.Name;
                item.querySelector("[selector='edit-tags']").value = galleryItem.Tags;
                item.querySelector("[selector='edit-date']").value = galleryItem.Date;
            });
            //updateData(referencedItem);
        }
    });
    req.open("GET", "/admin/api/gallery/items");
    req.send();
}
loadGallery();


const output = document.getElementById('date');
const name = document.getElementById("name");
const filepicker = document.getElementById('file');
var pickedFile = null;

filepicker.addEventListener('change', (event) => {
    const files = event.target.files;
    const now = new Date();
    output.textContent = '';

    for (const file of files) {
        pickedFile = file;
        const date = new Date(file.lastModified);
        console.log(date);
        output.value = date.toISOString().slice(0, 16);
        name.value = file.name.replace(/\.[^/.]+$/, "");
        document.getElementById('preview').src = window.URL.createObjectURL(file)
    }
});

function uploadImage() {
    let xhr = new XMLHttpRequest();

    let formData = new FormData();
    formData.append("Image", pickedFile);
    formData.append("Name", document.getElementById("name").value);
    formData.append("Date", document.getElementById("date").value);

    xhr.onload = (event) => {
        var response = JSON.parse(xhr.responseText);
        if (response['Id'] != undefined) {
            let xhr2 = new XMLHttpRequest();
            xhr2.open("POST", `/global/php/resize_images.php?id=${response['Id']}`);
            xhr2.send();
            xhr2.onload = (event) => {
                location.reload();
            }
        } else {
            console.log(response);
            // TODO: show error
        }
    }

    xhr.open("POST", "/admin/api/gallery/upload");
    xhr.send(formData);
}

function toggleUploadModal() {
    document.getElementById("upload-modal").classList.toggle("modal-hidden");
}