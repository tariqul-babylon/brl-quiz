
const menuIcon = $("#admin #right .topnav .left .menu-click");

menuIcon.click(function () {
    sidebarAction();
});


function sidebarAction() {
    $("#admin #sidebar").toggleClass('ml-250');
    $('#admin #right').toggleClass('tsx-265');
    $('#admin').toggleClass('sidebar-on');
}
function adminSidebar() {
    let width = $(window).width();
    if (width > 991) {
        $("#admin #sidebar").removeClass('ml-250');
        $('#admin #right').addClass('tsx-265');
    } else {
        $("#admin #sidebar").addClass('ml-250');
        $('#admin #right').removeClass('tsx-265');
    }
    console.log(width);
}
adminSidebar();

$(window).resize(function () {
    adminSidebar();
});

let schrollbarOptions = {
    //
    damping: 0.03
};
Scrollbar.init(document.querySelector('#sidebar-menu'), schrollbarOptions);
