<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Create Testimonial
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-12">
                          
                          <div class="panel-body">
                                      <testimonial-form
                                      image_preview='<?=base_url('/uploads/testimonials/').$testimonial->id.'_'.urlencode($testimonial->image_name)?>'
                                      form_url='<?=base_url('testimonials/update/').$testimonial->id?>'
                                      init_name='<?=$testimonial->name?>'
                                      init_occupation='<?=$testimonial->occupation?>'
                                      init_title='<?=$testimonial->title?>'
                                      init_testimonial='<?=$testimonial->testimonial?>'
                                      ></testimonial-form>
        
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
