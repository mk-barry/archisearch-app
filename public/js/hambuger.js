document.querySelectorAll('.nav-item').forEach(link => {
    link.addEventListener('click', () => {
        sidebar.style.display = 'none';
        over.classList.remove('overlay');
        main.classList.remove('disabled');
    });
});

function sidebarToggle(){
    const sidebar = document.getElementById('main-sidebar')
    const main = document.getElementById('main')
    const over = document.getElementById('overlay')


    if (sidebar.style.display === "flex") {
        sidebar.style.display = "none"
        over.classList.remove("overlay")
        main.style.marginLeft = "0"
        main.style.width = "100%"
        main.classList.remove("disabled")
    } else {
        over.classList.add("overlay")
        sidebar.style.display = "flex"
        main.classList.add("disabled")
    }

}


// // function sidebarToggle() {
// //     const sidebar = document.getElementById('main-sidebar');
// //     const main = document.getElementById('main');
// //     const over = document.getElementById('overlay');

// //     if (sidebar.classList.contains('open')) {
// //         sidebar.classList.remove('open');
// //         over.classList.remove('overlay');
// //         main.classList.remove('disabled');
// //     } else {
// //         sidebar.classList.add('open');
// //         over.classList.add('overlay');
// //         main.classList.add('disabled');
// //     }
// // }


// document.addEventListener('DOMContentLoaded', () => {
//     const sidebar = document.getElementById('main-sidebar');
//     const main = document.getElementById('main');
//     const overlay = document.getElementById('overlay');
//     const hamburgerBtn = document.getElementById('hambuger');
//     const closeBtn = document.querySelector('.fermeraside');

//     function toggleSidebar() {
//         sidebar.classList.toggle('open');
//         overlay.classList.toggle('active');
//         document.body.classList.toggle('no-scroll');
//     }

//     if (hamburgerBtn) hamburgerBtn.addEventListener('click', toggleSidebar);
//     if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
//     if (overlay) overlay.addEventListener('click', toggleSidebar);

//     // Fermeture fluide au clic sur un lien (sur mobile)
//     document.querySelectorAll('.nav-item').forEach(link => {
//         link.addEventListener('click', () => {
//             if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
//                 toggleSidebar();
//             }
//         });
//     });
// });