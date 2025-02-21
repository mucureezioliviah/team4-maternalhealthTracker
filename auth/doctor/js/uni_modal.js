function uni_modal(title, url) {
    $('#uni_modal .modal-title').html(title);
    $('#uni_modal .modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    $('#uni_modal').modal('show');
    $.ajax({
        url: url,
        error: function(err) {
            console.log(err);
            alert("An error occurred");
        },
        success: function(resp) {
            $('#uni_modal .modal-body').html(resp);
        }
    });
}

function alert_toast(message, type) {
    let toastHTML = `
    <div class="toast" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-${type}">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    </div>`;
    
    $('#msg').html(toastHTML);
    $('.toast').toast('show');
}


function start_load() {
    $('body').append('<div id="preloader"><div class="loader"></div></div>');
}
function end_load() {
    $('#preloader').remove();
}
