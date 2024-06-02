/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 
function initializeSelect2WithClose(selector) {
    $(selector).select2({
        placeholder: "Select an option",
        allowClear: true,
        theme: 'bootstrap-5'
    });
}

function showAlert(type, message) {
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
        '<h6>' + message + '</h6>' +
        '<button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
        '</div>';
    $('#alert-container').html(alertHtml); // Ensure you have a container with id "alert-container" in your HTML
}

window.addEventListener('DOMContentLoaded', event => {

    initializeSelect2WithClose(".select2");
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});
