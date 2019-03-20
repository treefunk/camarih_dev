

<section id="main-content">
    <section class="wrapper site-min-height app">
        <div class="panel-cs">
            <div class="panel-body">

                <create-package-form
                :package_data='<?=json_encode($package)?>'
                :packagegallery_data='<?=json_encode($package->package_gallery)?>'
                gallery_url="<?=base_url()?>uploads/package_gallery/"
                finish_button="Update"
                :destinations_data='<?=json_encode($destinations)?>'
                form_url='<?=base_url("tourpackages/update/{$package->id}")?>'
                ></create-package-form>
            
                
        </div>
        </div>
</section>


