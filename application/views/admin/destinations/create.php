<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Create Destination
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-6">
                          
                          <div class="panel-body">
                                      <form role="form" action="<?=base_url('destinations/store')?>" method="POST" enctype="multipart/form-data">
                                          
                                          <div class="form-group">
                                              <label for="header">Name</label>
                                              <input type="text" name="name" class="form-control" id="header" value="<?=set_value('name'); ?>" placeholder="Enter Destination Name">
                                          </div>
                                          <div class="form-group">
                                              <label for="short_name">Short Name</label>
                                              <input type="text" name="short_name" class="form-control" id="short_name"value="<?=set_value('short_name'); ?>" placeholder="Enter Short Name">
                                          </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Scope</label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="inlineCheckbox1" value="1" name="is_origin">Origin
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="inlineCheckbox2" value="1" name="is_dropoff">Passenger Drop off
                                                    </label>
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

