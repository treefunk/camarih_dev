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
                                      form_url='<?=base_url('testimonials/store')?>'
                                      init_name='<?=set_value('name'); ?>'
                                      init_occupation='<?=set_value('occupation'); ?>'
                                      init_title='<?=set_value('title'); ?>'
                                      init_testimonial='<?=set_value('testimonial'); ?>'
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
