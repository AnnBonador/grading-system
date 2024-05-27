function initializeSelect2WithClose(selector) {
    $(selector).select2({
        placeholder: "Select an option",
        allowClear: true,
        theme: "bootstrap-5",
    });
}

function showAlert(type, message) {
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
        '<h6>' + message + '</h6>' +
        '<button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
        '</div>';
    $('#alert-container').html(alertHtml); // Ensure you have a container with id "alert-container" in your HTML
}
