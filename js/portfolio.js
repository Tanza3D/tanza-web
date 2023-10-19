const pageEl = document.getElementById("portfolio-page");

function generatePortfolioPanel(item) {
    console.log(item);
    var div = document.createElement("div");
    div.setAttribute("hover", "small")
    div.setAttribute("click", "layer")

    div.className = "portfolio-item";
    var img = document.createElement("img");
    img.classList.add("lazy");
    
    img.src = `/public/img/gallery/wide.png`;
    img.setAttribute("data-src", "/img/portfolio/" + item.Id + "/" + item.Images[0].path)
 
    var imgBackdrop = document.createElement("img");
    imgBackdrop.classList.add("backdrop");
    imgBackdrop.classList.add("lazy");
    
    imgBackdrop.src = `/public/img/gallery/wide.png`;
    imgBackdrop.setAttribute("data-src", "/img/portfolio/" + item.Id + "/" + item.Images[0].path)
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
        console.log("UWU");
        console.log(json);
        var sorted = [];
        var curel = {
            "items": [],
            "type": "1x1"
        };
        var counter = 0;
        for (var item of json) {
            if(item.Website == "1") continue;
            item.Images = JSON.parse(item.Images);
            console.log("pushing to type " + curel.type);
            curel.items.push(item);
            if (curel.items.length >= 1 && curel.type == "1x1") {
                console.log("switching to 2x2 with " + curel.items.length);
                sorted.push(curel);
                curel = {
                    "items": [],
                    "type": "2x2"
                }
            }
            if (curel.items.length >= 4 && curel.type == "2x2") {
                sorted.push(curel);
                console.log("switching to 1x1");
                curel = {
                    "items": [],
                    "type": "1x1"
                }
            }
            counter++;
        }
        sorted.push(curel);
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

        for (var item of json) {
            if(item.Website == "0") continue;
            item.Images = JSON.parse(item.Images);
            var sectionEl = document.getElementById("portfolio-page-web");
            sectionEl.appendChild(generatePortfolioPanel(item));
        }
        audioSystem.registerAudios();

        var lazyLoadInstance = new LazyLoad({
            // Your custom settings go here
        });
    }
    xhr.send()
}
loadPortfolio();

function openItem(item) {
    var layer = document.getElementById("layer_content");

    document.getElementById("name").innerHTML = item.Name;
    document.getElementById("description").innerHTML = item.Description;
    document.getElementById("image-list").innerHTML = "";

    var imagecont = document.createElement("div");
    var counter = 0;
    var first = 2;
    for (var image of item.Images) {
        if(counter == 2 || first == 1) {
            first = 0;
            counter = 0;
            document.getElementById("image-list").appendChild(imagecont);
            var imagecont = document.createElement("div");
        }
        imagecont.className = "image-container";
        console.log(image);
        if(image.name != undefined) {
        var text = document.createElement("h1");
        text.innerText = image.name;
        }
        let imageElOuter = document.createElement("div");
        imageElOuter.classList.add("image-loading");
        if(image.name != undefined) {
        imageElOuter.appendChild(text);
        }
        let imageEl = document.createElement("img");
        imageEl.addEventListener("load", function() {
            console.log(imageEl);
            imageElOuter.style = "--ratio: " + imageEl.clientWidth / imageEl.clientHeight
            imageElOuter.classList.add("image-outer");
            imageElOuter.classList.remove("image-loading");
        });
        imageEl.src = "/img/portfolio/" + item.Id + "/" + image.path;
        imageElOuter.appendChild(imageEl);
        imagecont.appendChild(imageElOuter);
        counter++;
        if(first == 2) first = 1;
        
    }

    document.getElementById("image-list").appendChild(imagecont);

    openLayer("layer_info");
}