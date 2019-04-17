<section id="main-content" class="app">
    <section class="wrapper site-min-height">
        <section class="panel-cs">
            <header class="panel-heading">
                Contact Details
                <span class="pull-right"></span></header>
                <?php require_once __DIR__. "/../partials/alert.php"; ?> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <form role="form" action="<?=base_url()?>contactus/update" method="POST" enctype="multipart/form-data">
                            <div class="form-group"><label for="header">Send Inquiries to</label> <input type="text" name="recipient" id="header"
                                    value="<?=$recipient?>" class="form-control"></div>
                            <div class="form-group"><label for="header">Subject</label> <textarea name="subject"
                                    id="description" rows="3" class="form-control" style="height:inherit"><?=$subject?></textarea></div>
                           <button type="submit" class="btn_orange right_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>