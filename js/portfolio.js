const pageEl = document.getElementById("portfolio-page");

function generatePortfolioPanel(item) {
    console.log(item);
    var div = document.createElement("div");
    div.className = "portfolio-item";
    var img = document.createElement("img");
    img.src = "/img/portfolio/" + item.Id + "/" + item.Images[0].path;
    var imgBackdrop = document.createElement("img");
    imgBackdrop.classList.add("backdrop");
    imgBackdrop.src = "/img/portfolio/" + item.Id + "/" + item.Images[0].path;
    div.appendChild(img);
    div.appendChild(imgBackdrop);

    var title = document.createElement("h1");
    title.innerHTML = item['Name'];
    var description = document.createElement("h3");
    description.innerHTML = item['Description'];

    var overlay = document.createElement("div");
    overlay.classList.add("text-backdrop");
    div.appendChild(overlay);

    div.appendChild(title);
    div.appendChild(description);

    div.onclick = function() { openItem(item) };

    return div;
}

function loadPortfolio() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/portfolio/items");
    xhr.onload = function() {
        var json = JSON.parse(xhr.responseText);
        var sorted = [];
        var curel = {
            "items": [],
            "type": "2x2"
        };
        var counter = 0;
        for (var item of json) {
            item.Images = JSON.parse(item.Images);
            curel.items.push(item);
            if (curel.items.length >= 4 && curel.type == "2x2") {
                sorted.push(curel);
                curel = {
                    "items": [],
                    "type": "3x3"
                }
            }
            if (curel.items.length >= 9 && curel.type == "3x3") {
                sorted.push(curel);
                curel = {
                    "items": [],
                    "type": "2x2"
                }
            }
            counter++;
        }
        console.log(sorted);
        for (var section of sorted) {
            var sectionEl = document.createElement("div");
            sectionEl.classList.add("portfolio-section")
            sectionEl.classList.add("portfolio-section-" + section.type);
            for (var item of section.items) {
                sectionEl.appendChild(generatePortfolioPanel(item));
            }
            pageEl.appendChild(sectionEl)
        }
    }
    xhr.send()
}
loadPortfolio();

function openItem(item) {
    var layer = document.getElementById("layer_content");

    document.getElementById("name").innerHTML = item.Name;
    document.getElementById("description").innerHTML = item.Description;
    document.getElementById("image-list").innerHTML = "";
    for (var image of item.Images) {
        console.log(image);
        var imageContainer = document.createElement("div");
        var title = document.createElement("h1");
        var imageEl = document.createElement("img");
        title.innerHTML = image.name;
        imageEl.src = "/img/portfolio/" + item.Id + "/" + image.path;
        imageContainer.className = "image-container";
        imageContainer.appendChild(title);
        imageContainer.appendChild(imageEl);
        document.getElementById("image-list").appendChild(imageContainer);
    }

    openLayer("layer_info");
}