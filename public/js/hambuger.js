function sidebarToggle(){
    const sidebar = document.getElementById('main-sidebar')
    const main = document.getElementById('main')
    const over = document.getElementById('overlay')

    // console.log(sidebar.style.display);
    // sidebar.style.display = sidebar.style.display === "flex" ? "none" : "flex";
    // console.log(sidebar.style.display);

    if (sidebar.style.display === "flex") {
        sidebar.style.display = "none"
        // sidebar.style.width = "30%"
        over.classList.remove("overlay")
        main.style.marginLeft = "0"
        main.style.width = "100%"
    } else {
        over.classList.add("overlay")
        sidebar.style.display = "flex"
        main.classList.add("disabled")
        // sidebar.style.backgroundColor = "red"
        // sidebar.style.width = "30%"
        // main.style.width = "70%"
        // main.style.transform = "blur(10%)"
        // main.style.marginLeft = "30%"
    }

}