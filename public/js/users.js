let limit=10;
let itemName = "page-item";
let current_page = 1;

window.onload = function(){
    toogleSideBar();
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            current_page = 1;
            updatePage(xhr);
        }
    }
    url = "/app/controllers/UserController.php?offset=0&limit="+limit.toString();


    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}

function updatePage(xhr) {
    let contents = document.getElementsByClassName("contents")[0];
    console.log(xhr.responseText);
    let result = JSON.parse(xhr.responseText);

    if(result[0] !== "") {
        contents.innerHTML = result[0];
        console.log("result[0]: "+result[0]);
        let countUser = result[1];
        let countPage = Math.ceil(countUser/limit);
        // testing doang
        // current_page = 6;
        // let countPage = 10;
        console.log("count page: "+countPage);
        generatePagination(countPage);
    } else {
        pagination = document.getElementsByClassName("pagination")[0];
        pagination.innerHTML = "";
    }
}

function toogleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("users");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}

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
        let url = "/app/controllers/UserController.php?offset="+((page-1)*limit).toString()+"&limit="+limit.toString();
        console.log("page:"+page+" url:"+url);
        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    });
    console.log("page item:"+pageItem.innerHTML);
    // pagination.appendChild(pageItem);
}