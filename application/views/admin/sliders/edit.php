<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Edit Slider
                      <span class="pull-right"> 
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-6">
                    
                          
                          <div class="panel-body">
                                      <form role="form" action="<?=base_url('sliders/update/') . $slider->id?>" method="POST" enctype="multipart/form-data">
                                        
                                          
                                          <img src="<?=base_url('/uploads/sliders/').$slider->id.'_'.$slider->image_name?>" class="img-responsive" alt="Image">
                                          
                                      
                                      
                                          <div class="form-group">
                                              <label for="image_name">Image</label>
                                              <input name="image_name" type="file" id="image_name" value="<?=$slider->image_name?>" >
                                              <!-- <p class="help-block">Example block-level help text here.</p> -->
                                          </div>
                                          <div class="form-group">
                                              <label for="header">Header</label>
                                              <input type="text" name="header" class="form-control" id="header" value="<?=$slider->header?>" placeholder="Enter Header">
                                          </div>
                                          <div class="form-group">
                                              <label for="sub_header">Sub Header</label>
                                              <input type="text" name="sub_header" class="form-control" id="sub_header"value="<?=$slider->sub_header?>" placeholder="Enter Sub Header">
                                          </div>

                                          <div class="form-group">
                                              <label for="button_text_first">First Button Text</label>
                                              <input type="text" name="button_text_first" class="form-control" value="<?=$slider->button_text_first?>" id="button_text_first">
                                          </div>

                                          <div class="form-group">
                                              <label for="button_link_first">First Button Link</label>
                                              <input type="text" name="button_link_first" class="form-control" value="<?=$slider->button_link_first?>" id="button_link_first">
                                          </div>

                                          <div class="form-group">
                                              <label for="button_text_second">Second Button Text</label>
                                              <input type="text" name="button_text_second" class="form-control" value="<?=$slider->button_text_second?>" id="button_text_second">
                                          </div>

                                          <div class="form-group">
                                              <label for="button_link_second">Second Button Link</label>
                                              <input type="text" name="button_link_second" class="form-control" value="<?=$slider->button_link_second?>" id="button_link_second">
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

<?php //todo change password ?>
