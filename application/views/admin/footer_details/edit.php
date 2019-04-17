<section id="main-content" class="app">
    <section class="wrapper site-min-height">
        <section class="panel-cs">
            <header class="panel-heading">
                Footer Details
                <span class="pull-right"></span></header>
                <?php require_once __DIR__. "/../partials/alert.php"; ?> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <form role="form" action="<?=base_url()?>footer_details/update" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group"><label for="header">Header</label> <input type="text"
                                    name="header" id="header" value="<?=$header?>" class="form-control"></div>
                            <div class="form-group"><label for="header">Body</label> <textarea name="body"
                                    id="description" rows="3" class="form-control" style="height:inherit"><?=$body?></textarea>
                            </div>
                            <h4 class="panel-heading">Contact Information</h4>
                            <div class="form-group"><label for="address">Address</label> <textarea name="address"
                                    id="description" rows="3" class="form-control" style="height:inherit"><?=$address?></textarea>
                            </div>
                            <div class="form-group"><label for="phone_1">Phone #1</label> <input type="text"
                                    name="phone_1" id="phone_1" value="<?=$phone_1?>" class="form-control"></div>
                            <div class="form-group"><label for="phone_2">Phone #2</label> <input type="text"
                                    name="phone_2" id="phone_2" value="<?=$phone_2?>" class="form-control"></div>
                            <div class="form-group"><label for="email">Email</label> <input type="text"
                                    name="email" id="email" value="<?=$email?>" class="form-control"></div>
                            <div class="form-group"><label for="facebook_link">Facebook Link</label> <input type="text"
                                    name="facebook_link" id="facebook_link" value="<?=$facebook_link?>" class="form-control"></div>
                            <div class="form-group"><label for="messenger_link">Messenger Link</label> <input type="text"
                                    name="messenger_link" id="messenger_link" value="<?=$messenger_link?>" class="form-control"></div>
                            <button type="submit" class="btn_orange right_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>