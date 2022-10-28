let limit=10;
let current_url=""; //tanpa offset & limit
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

//komen dulu buat frontend
window.onload = function(){
    toggleSideBar();
    
    let xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            updatePage(xhr);
        }
    }
    url = "/app/controllers/SearchController.php";
    if(location.search!=="") {
        url = url+location.search+"&offset=0&limit="+limit.toString();
        current_url = location.search;
        let judul = new URLSearchParams(location.search).get("search");
        document.getElementsByClassName("container-title")[0].innerHTML = "Search for \""+judul+"\"";
    } else {
        url = url+"?search=";
        current_url="?search=";
        document.getElementsByClassName("container-title")[0].innerHTML = "All songs";
    }

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

function toggleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("home");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}

function getDetailedSong($id){
    window.location.href = "/public/detail-song.php?id="+$id;
}

function updatePage(xhr) {
    let contents = document.getElementsByClassName("contents")[0];
    let response = JSON.parse(xhr.responseText);
    if(response[0] !== "") {
        contents.innerHTML = response[0];
        console.log("response[0]: "+response[0]);
        let countSong = response[1];
        let countPage = Math.ceil(countSong/limit);
        // testing doang
        // current_page = 6;
        // let countPage = 10;
        console.log("count page: "+countPage);
        generatePagination(countPage);
    } else {
        contents.innerHTML = "<tr> Unfortunately, there is no song that matched </tr>";
        pagination = document.getElementsByClassName("pagination")[0];
        pagination.innerHTML = "";
    }
}

//add event listener to every button
function generatePagination(countPage) {
    let pagination = document.getElementsByClassName("pagination")[0];
    pagination.innerHTML = "";
    //coba pake cara lain
    // while(pagination.lastChild) {
    //     pagination.removeChild(pagination.lastChild);
    // }
    // page 1
    // pagination.innerHTML += "<li class='page-item active'>1</li>";
    if(countPage > 1 || current_page>1) {
        addPagination(pagination,1);
        // page ... atau cur-2,cur-1,cur
        if(current_page>4) {
            let last = document.createElement("li");
            last.classList.add("page-item");
            last.innerHTML = "...";
            pagination.appendChild(last);  
        }
        for(let i=Math.max(2,current_page-2);i<=current_page;i++) {
            console.log("i: "+i);
            addPagination(pagination,i);
        }
        pagination.lastElementChild.style.backgroundColor = "#1DB954";
        pagination.lastElementChild.style.color = "#000";
        console.log("pagination line 92: "+pagination.innerHTML);
        // page cur+1,cur+2, ...
        for(let i=current_page+1;i<=Math.min(current_page+countPage-1,current_page+2);i++) { //ohh salah, kl current = last_page-1,count_page=2
            addPagination(pagination,i);
        }
        if(countPage>3) {
            // pagination.innerHTML += "<li class='page-item'>...</li>";
            let last = document.createElement("li");
            last.classList.add("page-item");
            last.innerHTML = "...";
            pagination.appendChild(last);            
        }
    }
}

function addPagination(pagination,page) {
    console.log("page: "+page);
    let pageItem = document.createElement("li");
    pageItem.classList.add("page-item");
    let pageItemChild = document.createElement("div");
    pageItemChild.classList.add("active");
    pageItemChild.innerHTML = page.toString();
    console.log(pageItemChild.innerHTML);
    pageItem.appendChild(pageItemChild);
    pagination.appendChild(pageItem);
    
    pageItem.addEventListener("click", function() {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                current_page = page;
                updatePage(xhr);
            }
        };
        xhr.onerror = function() {
            console.log("error");
        };
        xhr.onabort = function() {
            console.log("abort");
        }
        let url = "/app/controllers/SearchController.php" +current_url+"&offset="+((page-1)*limit).toString()+"&limit="+limit.toString();
        console.log("page:"+page+" url:"+url);
        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    });
    console.log("page item:"+pageItem.innerHTML);
    // pagination.appendChild(pageItem);
}


let searchInput = document.getElementById("search-input");
searchInput.addEventListener("keyup", debounce(function(event) {
    let xhr = new XMLHttpRequest();
    let keyword = document.getElementById("search-input").value;
    let url = "/app/controllers/SearchController.php?search="+keyword+"&offset=0&limit="+limit.toString();
    // cek komponen sort
    // cek komponen filter
    current_url = "?search="+keyword;
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            // location.search = current_url;
            updatePage(xhr);
        }
    }
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
},1000));

let sort_select = document.getElementById("sort-select");
sort_select.addEventListener("change", function() {
    let xhr = new XMLHttpRequest();
    let keyword = document.getElementById("search-input").value;
    let orderQry =  this.value.split(" ");
    console.log(orderQry);
    let filterGenre = document.getElementById("filter-select").value;
    let orderby = orderQry[0];
    let order = orderQry[1];
    let url = "/app/controllers/SearchController.php?search="+keyword+"&orderby="+orderby+"&order="+order;
    current_url = "?search="+keyword+"&orderby="+orderby+"&order="+order;
    if(filterGenre!=="Genre") {
        url += "&genre="+filterGenre;
        current_url += "&genre="+filterGenre;
    }
    url +="&offset=0&limit="+limit.toString();
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            // let judul = 
            updatePage(xhr);
        }
    }
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
});

let filter_genre = document.getElementById("filter-select");
filter_genre.addEventListener("change", function() {
    let xhr = new XMLHttpRequest();
    let keyword = document.getElementById("search-input").value;
    let genre = this.value;
    let orderQry = document.getElementById("sort-select").value.split(" ");
    let orderby = orderQry[0];
    let order = orderQry[1];
    let url = "/app/controllers/SearchController.php?search="+keyword+"&orderby="+orderby+"&order="+order;
    current_url = "?search="+keyword+"&orderby="+orderby+"&order="+order;
    if(genre!=="Genre") {
        url += "&genre="+genre;
        current_url += "&genre="+genre;
    }
    url +="&offset=0&limit="+limit.toString();
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            updatePage(xhr);
        }
    }
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
});