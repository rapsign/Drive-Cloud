<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- Main Content -->
<main role="main" class="col-lg-10 ml-lg-auto col-lg-10 px-md-4 content ">
    <h3 class="text-center mb-3">Upload File</h3>

    <!--begin::Form-->
    <form class="form" action="#" method="post">
        <!--begin::Input group-->
        <div class="fv-row">
            <!--begin::Dropzone-->
            <div class="dropzone" id="kt_dropzonejs_example_1" style="border: 3px dashed #007bff;">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-3">Drop files here or click to upload.</h3>
                        <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->
    </form>
    <!--end::Form-->
</main>

<?= $this->endSection(); ?>