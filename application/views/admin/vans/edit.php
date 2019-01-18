<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Create Van
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-6">
                          
                          <div class="panel-body">
                                      <form role="form" action="<?=base_url('vans/update/').$van->id?>" method="POST" enctype="multipart/form-data">
                                          
                                      <div class="form-group">
                                              <label for="header">Name</label>
                                              <input type="text" name="name" class="form-control" id="header" value="<?=$van->name?>" placeholder="Enter Van Name">
                                          </div>
                                          <label for="header">Description</label>
                                          <textarea name="description" id="description" class="form-control" rows="3"><?=$van->description?></textarea>
                                          
                                          <div class="form-group">
                                              <label for="sub_header">Seat Count</label>
                                              <input type="text" name="seat_count" class="form-control" id="sub_header"value="<?=$van->seat_count?>" placeholder="Enter Seat Count">
                                          </div>

                                        
                                          <button type="submit" class="btn btn-info">Submit</button>
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

