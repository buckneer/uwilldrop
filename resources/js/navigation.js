
function toggleNavbar() {
    $('#sidebar').toggleClassName('.sidebar-hidden');
    $("#navbar").toggle();
}

function showSidebar() {
    $("#sidebar").toggleClass("sidebar-hidden");
}

$("#toggleButton").on("click", showSidebar);
$("#closeSidebar").on("click", showSidebar);

$(window).on('load resize', function() {
    if ($(this).width() < 1024) { // Adjust the breakpoint as needed
        $('#sidebar').addClass("sidebar-hidden"); // Replace '.navbar' with your actual navbar selector
        $("#navbar").show();
    } else {
        $('#sidebar').removeClass("sidebar-hidden"); // Replace '.navbar' with your actual navbar selector
        $("#navbar").hide();
    }
});
