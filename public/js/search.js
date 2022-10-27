let limit=10;
let current_url="";
let itemName = "page-item";
let current_page = 1;
const debounce = (func, delay) => {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
};

window.onload = function(){
    toogleSideBar();
    
    let xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            updatePage(xhr);
        }
    }
    url = "/app/controllers/SearchController.php";
    url = url+location.search;
    current_url = location.search;

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
};

// function GetParameter() {
//     var result = null,
//         tmp = [];
//     location.search
//         .substring(1)
//         .split("&")
//         .forEach(function (item) {
//           tmp = item.split("=");
//         //   if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
//         result[tmp[0]] = decodeURIComponent(tmp[1]);
//         });
//     return result;
// }

function toogleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("home");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}

function updatePage(xhr) {
    let contents = document.getElementsByClassName("contents")[0];
    let response = JSON.parse(xhr.responseText);
    if(response[0] !== "") {
        contents.innerHTML = response[0];
        let countSong = response[1];
        let countPage = Math.ceil(countSong/limit);
        generatePagination(countPage);
    } else {
        contents.innerHTML = "<tr> Unfortunately, there is no song that matched </tr>";
    }
}

//add event listener to every button
function generatePagination(countPage) {
    let pagination = document.getElementsByClassName("pagination")[0];
    pagination.innerHTML = "";
    // page 1
    // pagination.innerHTML += "<li class='page-item active'>1</li>";
    addPagination(pagination,1);
    // page ... atau cur-2,cur-1,cur
    if(current_page>4) {
        pagination.innerHTML += "<li class='page-item'>...</li>";
    }
    for(let i=max(2,current_page-2);i<=current_page;i++) {
        addPagination(pagination,i);
    }
    // page cur+1,cur+2, ...
    for(let i=current_page+1;i<=min(current_page+countPage-1,current_page+2);i++) {
        addPagination(pagination,i);
    }
    if(countPage>3) {
        pagination.innerHTML += "<li class='page-item'>...</li>";
    }
}

function addPagination(pagination,page) {
    let pageItem = document.createElement("li");
    pageItem.classList.add("page-item");
    pageItem.classList.add("active");
    pageItem.innerHTML = toString(page);
    pagination.appendChild(pageItem);
    pageItem.addEventListener("click", function() {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                current_page = page;
                updatePage(xhr);
            }
        };
        let url = "/app/controllers/SearchController.php" +current_url+"&offset="+toString((page-1)*limit)+"&limit="+toString(limit);
        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    });
}


let searchInput = document.getElementById("search-input");
searchInput.addEventListener("keyup", debounce(function(event) {
    let xhr = new XMLHttpRequest();
    let keyword = document.getElementById("search-input").value;
    let url = "/app/controllers/SearchController.php?search="+keyword+"&offset=0&limit="+toString(limit);
    // cek komponen sort
    // cek komponen filter
    current_url = "?search="+keyword+"&offset=0&limit="+toString(limit);
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            location.search = current_url;
            updatePage(xhr);
        }
    }
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
},1000));
