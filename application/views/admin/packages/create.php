<script src="<?=base_url('node_modules/ckeditor/ckeditor.js')?>"></script>
<section id="main-content">
    <section class="wrapper site-min-height app">
        <div class="panel-cs">
          <div class="panel-body tour-package">
                <create-package-form
                finish_button="Create"
                :destinations_data='<?=json_encode($destinations)?>'
                form_url='<?=base_url('tourpackages/store')?>'
                ></create-package-form>
        </div>
        </div>
</section>


