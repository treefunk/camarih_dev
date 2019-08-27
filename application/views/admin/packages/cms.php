<section id="main-content" class="app">
    <section class="wrapper site-min-height">
        <section class="panel-cs">
            <header class="panel-heading">
                Day Tours
                <span class="pull-right"></span></header>
                <?php require_once __DIR__. "/../partials/alert.php"; ?> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <form role="form" action="<?=base_url('tourpackages/updateCMS')?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group"> <textarea placeholder="Input description" name="day_tours_description"
                                    id="description" rows="6" class="form-control" style="height:inherit"><?php echo $day_tours_desc ?></textarea>
                            </div>
                            <h4 class="panel-heading">Package Tours</h4>
                            <div class="form-group"><textarea placeholder="Input description" name="package_tours_description"
                                    id="description" rows="6" class="form-control" style="height:inherit"><?php echo $package_tours_desc ?></textarea>
                            </div>
                            <button type="submit" class="btn_orange right_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>