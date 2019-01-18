<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Create Testimonial
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-6">
                          
                          <div class="panel-body">
                                      <form role="form" action="<?=base_url('testimonials/update/').$testimonial->id?>" method="POST" enctype="multipart/form-data">
                                          
                                        <img src="<?=base_url('/uploads/testimonials/').$testimonial->id.'_'.$testimonial->image_name?>" class="img-responsive" alt="Image">
                                            <div class="form-group">
                                              <label for="image_name">Image</label>
                                              <input name="image_name" type="file" id="image_name" value="<?=$testimonial->image_name?>" >
                                              <!-- <p class="help-block">Example block-level help text here.</p> -->
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control" id="name"value="<?=$testimonial->name?>" placeholder="Enter Name">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" name="occupation" class="form-control" value="<?=$testimonial->occupation?>" id="occupation">
                                            </div>

                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" class="form-control" value="<?=$testimonial->title?>" id="title">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="testimonial">Testimonial</label>
                                                <textarea name="testimonial" class="form-control" id="testimonial" placeholder="Enter Testimonial"><?=$testimonial->testimonial?></textarea>
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
