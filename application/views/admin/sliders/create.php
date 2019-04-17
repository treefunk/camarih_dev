<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Create Slider
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-6">
                          
                          <div class="panel-body">

                                      <create-slider-form
                                      form_url='<?=base_url('sliders/store')?>'
                                      init_header='<?=set_value('header')?>'
                                      init_sub_header='<?=set_value('sub_header')?>'
                                      init_button_text_first='<?=set_value('button_text_first')?>'
                                      init_button_link_first='<?=set_value('button_link_first')?>'
                                      init_button_text_second='<?=set_value('button_text_second')?>'
                                      init_button_link_second='<?=set_value('button_link_second')?>'
                                      init_is_featured='<?=(boolean)set_checkbox('is_featured', 0);?>'
                                      ></create-slider-form>
        
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
