<section id="main-content">
    <section class="wrapper site-min-height app">
        <div class="panel-cs">
          <div class="panel-body">
            <form  role="form" method="POST" action="<?=base_url('tourpackages/store')?>" enctype="multipart/form-data" class="form-horizontal" >
                <create-package-form
                finish_button="Create"
                :destinations_data='<?=json_encode($destinations)?>'
                ></create-package-form>
            </form>
        </div>
        </div>
</section>


