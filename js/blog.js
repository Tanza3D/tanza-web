function checkParams() {
    if (getParam("post") != null) {
        openPost(getParam("post"), true);
    } else {
        closePost();
    }
}
checkParams();
window.addEventListener("popstate", checkParams);

function closePost() {
    removeParam("post");
    document.getElementById("home").classList.remove("hidden-full");
    document.getElementById("post").classList.add("hidden-full");
    window.scrollTo(0,0);
}

function openPost(postname, from_param = false) {
    if (from_param == false) {
        insertParam("post", postname);
    }
    document.getElementById("home").classList.add("hidden-full");
    document.getElementById("post").classList.remove("hidden-full");

    var post = null;
    for (var posts of postdata) {
        console.log(posts);
        if (posts["InternalName"] == postname) {
            post = posts;
        }
    }

    marked.use({
        pedantic: false,
        breaks: true,
        gfm: true,
    });

    document.getElementById("post-content").innerHTML = marked.parse(post.PostData);
    document.getElementById("post-cover").src = "https://raw.githubusercontent.com/Tanza3D/blog/main/"+post.InternalName+"/cover.png"
    document.getElementById("post-title").innerHTML = post.Name;
    document.getElementById("post-date").innerHTML = post.ReleaseDate;
    window.scrollTo(0,0);
    return false;
}