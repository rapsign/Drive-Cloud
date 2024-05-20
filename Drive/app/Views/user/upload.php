<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- Main Content -->
<main role="main" class="col-lg-10 ml-lg-auto col-lg-10 px-md-4 content ">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3 class="text-center mb-4">Upload File</h3>
            <div id="drag-drop-area" class="drag-drop-area">
                Drag & Drop your file here or <br>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">Browse Files</button>
                <input type="file" id="fileInput" multiple style="display:none;">
            </div>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>