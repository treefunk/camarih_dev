<section id="main-content" class="app">
    <section class="wrapper site-min-height">
        <section class="panel-cs">
            <header class="panel-heading">
                About Us
                <span class="pull-right"></span></header>
                <?php require_once __DIR__. "/../partials/alert.php"; ?> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <form role="form" action="<?=base_url()?>/about/update" method="POST" enctype="multipart/form-data">
                            <div class="form-group"><label for="header">Header</label> <input type="text" name="header" id="header"
                                    value="<?=$about->header?>" class="form-control"></div>
                            <div class="form-group"><label for="header">Description</label> <textarea name="body"
                                    id="description" rows="30" class="form-control" style="height:inherit"><?=$about->body?></textarea></div>
                           <button type="submit" class="btn_orange right_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>