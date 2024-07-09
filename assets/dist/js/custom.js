$(function () {

    $("#table-default1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table-default1_wrapper .col-md-6:eq(0)');

    $('#table-default2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
function logout() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        // Check if the user confirmed the logout
        if (result.isConfirmed) {
            // Perform logout action
            window.location.href = '../logout.php';
        }
    });
}

function swal_alert(title, text, icon, location = '') {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (location != '') {
            window.location.href = location;
        }
    });
}

function viewImage(image) {
    Swal.fire({
        imageUrl: image.src,
        imageWidth: 400,
        imageHeight: 400,
        imageAlt: 'User Profile Picture',
    });
}
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + previewId).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}