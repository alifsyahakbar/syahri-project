const sidebar = document.querySelector('.sidebar-fixed');

const fixedNav = header.offsetTop;

if(window.pageYOffset > fixedNav) {
    header.classList.add('navbar-fixed');
    sidebar.classList.remove('hidden');
    sidebar.classList.add('flex');
} else {
    header.classList.remove('navbar-fixed');
    sidebar.classList.remove('flex'); 
    sidebar.classList.add('hidden');
}