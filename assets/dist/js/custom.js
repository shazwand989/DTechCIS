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

function categorySubEdit(id, name) {
    if (id == 0) {
        $('#modal-title').text('Add');
        $('#category_sub_id').val(0);
        $('#sub_category_name').val('');
    } else {
        $('#modal-title').text('Edit');
        $('#category_sub_id').val(id);
        $('#sub_category_name').val(name);
    }
    $('#modal-category-sub').modal('show');
}

function goBack() {
    window.history.back();
}

function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        // Check if the user confirmed the deletion
        if (result.isConfirmed) {
            // ajax call to delete user
            $.ajax({
                type: 'POST',
                url: 'user-delete.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        swal_alert('Success', response.message, 'success', 'user-list.php?role=' + response.role);
                    } else {
                        swal_alert('Error', response.message, 'error');
                    }
                }
            });
        }
    }
    );
}

function deleteCategory(category_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this category!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'category-delete.php',
                type: 'POST',
                data: {
                    category_id: category_id
                },
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                }
            });
        }
    });
}

function deleteCategorySub(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this category!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        // Check if the user confirmed the deletion
        if (result.isConfirmed) {
            // ajax call to delete user
            $.ajax({
                type: 'POST',
                url: 'category-sub-delete.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        swal_alert('Success', response.message, 'success', 'category-detail.php?id=' + response.category_id);
                    } else {
                        swal_alert('Error', response.message, 'error');
                    }
                }
            });
        }
    }
    );
}

function deleteDocument(documentId) {
    // sweetalert
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this document?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // ajax
            $.ajax({
                url: 'category-document-delete.php',
                type: 'POST',
                data: {
                    document_id: documentId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire(
                            'Deleted!',
                            'Document has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            'Failed to delete document.',
                            'error'
                        );
                    }
                }
            });
        }
    });
}