

<script src="<?=base_url('node_modules/ckeditor/ckeditor.js')?>"></script>
<section id="main-content">
    <section class="wrapper site-min-height app">
        <div class="panel-cs">
            <div class="panel-body">

                <create-package-form
                :package_data='<?=json_encode($package)?>'
                :uploaded_images_data='<?=json_encode($package->package_gallery)?>'
                gallery_url="<?=base_url()?>uploads/package_gallery/"
                finish_button="Update"
                :destinations_data='<?=json_encode($destinations)?>'
                form_url='<?=base_url("tourpackages/update/{$package->id}")?>'
                downloads_url='<?=base_url($this->packagedownload_model->upload_path)?>'
                main_image_url='<?=base_url($this->packageimage_model->upload_path)?>'
                ></create-package-form>
            
                
        </div>
        </div>
</section>


