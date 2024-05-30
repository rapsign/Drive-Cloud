document.onreadystatechange = function() {
    if (document.readyState !== "complete") {
        document.querySelector("#loading-screen").style.visibility = "visible";
    } else {
        setTimeout(function() {
            document.querySelector("#loading-screen").style.display = "none";
            document.querySelector("main").style.visibility = "visible";
        });
    }
};

$('#renameFolder').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');

    var modal = $(this);
    modal.find('#folder-id').val(id);
    modal.find('#folder-name').val(name);
});

$('#renameFile').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');
    var filenameWithoutExt = name.split('.').slice(0, -1).join('.');
    var filenameExt = name.split('.').pop();

    var modal = $(this);
    modal.find('#file-id').val(id);
    modal.find('#file-name').val(filenameWithoutExt);
    modal.find('#file-ext').val(filenameExt);
});

$('#moveFile').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');

    var modal = $(this);
    modal.find('#file-id').val(id);
    modal.find('#file-name').val(name);
    modal.find('#file-name-display').text(name);
    modal.find('#selected-folder').val('');
    $('#move-button').prop('disabled', true);
    $('#folder-list .list-group-item').removeClass('active');
});

$('#folder-list').on('click', '.list-group-item', function() {
    $('#folder-list .list-group-item').removeClass('active');
    $(this).addClass('active');
    var selectedFolder = $(this).data('folder');
    $('#selected-folder').val(selectedFolder);
    $('#move-button').prop('disabled', false);
});

$('#moveFileForm').on('submit', function(event) {
    if ($('#selected-folder').val() === '') {
        event.preventDefault();
        alert('Please select a folder to move the file.');
    }
});

function Delete(event) {
    event.preventDefault(); 
    Swal.fire({
        title: 'Are you sure?',
        text: "This folder will be moved to the Trash",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Move to trash'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.parentElement.submit(); 
        }
    });
}

function fileDelete(event) {
    event.preventDefault(); 
    Swal.fire({
        title: 'Are you sure?',
        text: "This file will be moved to the Trash",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Move to trash'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.parentElement.submit(); 
        }
    });
}

function deleteTrash(event) {
    event.preventDefault(); 
    Swal.fire({
        title: 'Delete forever?',
        text: "All items in the trash will be deleted forever and you won't be able to restore it",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete forever'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.parentElement.submit(); 
        }
    });
}

function deleteFile(event) {
    event.preventDefault(); 
    var fileName = event.target.parentElement.querySelector('[name="fileName"]').value; 
    Swal.fire({
        title: 'Delete forever?',
        text: fileName + " will be deleted forever and you won't be able to restore it",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete forever'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.parentElement.submit(); 
        }
    });
}

function deleteFolder(event) {
    event.preventDefault(); 
    var folderName = event.target.parentElement.querySelector('[name="folderName"]').value; 
    Swal.fire({
        title: 'Delete forever?',
        text: folderName + " will be deleted forever and you won't be able to restore it",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'forever'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.parentElement.submit(); 
        }
    });
}

var myDropzone1 = new Dropzone("#kt_dropzonejs_example_1", {
    url: "<?= base_url('user/addFiles') ?>",
    paramName: "file",
    maxFiles: 10,
    init: function() {
        this.on("complete", function(file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                location.reload();
            }
        });
    }
});

var urlSegments = window.location.pathname.split('/');
var lastSegment = urlSegments[urlSegments.length - 1];
var url = "<?= base_url('user/addFiles/') ?>" + lastSegment;
var myDropzone2 = new Dropzone("#kt_dropzonejs_example_2", {
    url: url,
    paramName: "file",
    maxFiles: 10,
    init: function() {
        this.on("complete", function(file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                location.reload();
            }
        });
    }
});



document.addEventListener('DOMContentLoaded', function() {
    function adjustDropdownPosition() {
        document.querySelectorAll('.dropdown-submenu.dropright').forEach(function(element) {
            var rect = element.getBoundingClientRect();

            if (rect.right >= window.innerWidth) {
                element.classList.remove('dropright');
                element.classList.add('dropleft');
            } else {
                element.classList.remove('dropleft');
                element.classList.add('dropright');
            }
        });
    }

    adjustDropdownPosition();

    window.addEventListener('resize', adjustDropdownPosition);

    document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var parent = e.target.closest('.dropdown-submenu');
            parent.classList.toggle('show');
            var subMenu = parent.querySelector('.dropdown-menu');
            if (subMenu) {
                subMenu.classList.toggle('show');
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.dropdown-submenu.show').forEach(function(submenu) {
                submenu.classList.remove('show');
            });
        }
    });

    document.querySelectorAll('.dropdown').forEach(function(dropdown) {
        dropdown.addEventListener('hide.bs.dropdown', function() {
            this.querySelectorAll('.dropdown-submenu .show').forEach(function(submenu) {
                submenu.classList.remove('show');
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const addFileButton = document.getElementById('addFileButton');
    const addFileForm = document.getElementById('addFileForm');

    addFileButton.addEventListener('click', function() {
        addFileForm.style.display = addFileForm.style.display === 'none' ? 'block' : 'none';
    });
});
