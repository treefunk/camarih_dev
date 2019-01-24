<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Create Van
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-12">
                          
                          <div class="panel-body">
                                      <form role="form" action="<?=base_url('vans/store')?>" method="POST" enctype="multipart/form-data">
                                          
                                          <div class="form-group">
                                              <label for="header">Name</label>
                                              <input type="text" name="name" class="form-control" id="header" value="<?=set_value('name'); ?>" placeholder="Enter Van Name">
                                          </div>
                                          <div class="form-group">
                                          <label for="header">Description</label>
                                          <textarea name="description" id="description" class="form-control" rows="3"><?=set_value('description')?></textarea>
                                          </div>
      
                                          <div class="form-group">
                                            <van-seat-map
                                            
                                            ></van-seat-map>
                                          </div>
                                          


                                          <button type="submit" class="btn_orange right_btn">Submit</button>

                                      </form>
        
                            </div>

                      </div>
                  </div>


              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php //require_once "modals/delete.php"; //Edit modal here ?>

