$(function () {
    checkCookie();
    checkDarkTheme();
    checkDarkIcon();
    alertify.defaults.theme.ok = "btn btn-success";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.glossary.ok = "بله";
    alertify.defaults.glossary.cancel = "نه";
});
let btnOpenSearch = document.getElementById("btn-open-search");
let navSearch = document.getElementsByClassName("nav-search")[0];
let closeSearch = navSearch.getElementsByClassName("close")[0];
let mainBody = document.getElementsByTagName("body")[0];
let btnOpenUser = document.getElementById("btn-open-user");
let btnSwitchTheme = document.getElementById("btn-switch-theme");
let btnOpenSidebar = document.getElementById("btn-open-sidebar");
let userContent = $("#user-content");
btnOpenSearch.onclick = function () {
    navSearch.classList.add("open");
};
function editGroup(url) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (result) {
            alertify.confirm(
                "ویرایش گروه",
                result,
                function () {
                },
                function () {
                }
            ).set('basic', true);
        }
    });
}
closeSearch.onclick = function () {
    if (navSearch.classList.contains("remove-animation")) {
        navSearch.classList.remove("remove-animation");
    }
    navSearch.classList.remove("remove-animation");
    navSearch.classList.add("close");
    setTimeout(function () {
        navSearch.classList.remove("open");
        navSearch.classList.remove("close");
    }, 250);
};
btnOpenUser.onclick = function () {
    userContent.slideToggle(250);
};
$(function () {
    $(window).resize(function () {
        if (navSearch.classList.contains("open")) {
            navSearch.classList.add("remove-animation");
        }
    });
});
btnOpenSidebar.onclick = function () {
    mainBody.classList.toggle("sidebar-expanded");
};
btnSwitchTheme.onclick = function () {
    if (!mainBody.classList.contains("dark")) {
        mainBody.classList.add("dark");
        setCookie("dark", "1", 30);
    } else {
        mainBody.classList.remove("dark");
        setCookie("dark", "0", 30);
    }
    checkDarkTheme();
}
function setCookie(cname, cvalue, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    let name = cname + "=";
    let allCookie = decodeURIComponent(document.cookie).split(';');
    let cval = [];
    for(let i=0; i < allCookie.length; i++) {
        if (allCookie[i].trim().indexOf(name) === 0) {
            cval = allCookie[i].trim().split("=");
        }
    }
    return (cval.length > 0) ? cval[1] : "";
}
function checkCookie() {
    let style = getCookie("dark");
    if (style !== "") {
        if (style === "1") {
            mainBody.classList.add("dark");
        } else if (style === "0") {
            mainBody.classList.remove("dark");
        }
    }
}
function checkDarkTheme() {
    let i = btnSwitchTheme.querySelector('i');
    i.className = mainBody.classList.contains('dark') ? "sun" : "moon";
}