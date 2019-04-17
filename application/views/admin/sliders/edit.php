<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel-cs">
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


                                      <create-slider-form
                                      form_url='<?=base_url('sliders/update/') . $slider->id?>'
                                      init_header='<?=$slider->header?>'
                                      init_sub_header='<?=$slider->sub_header?>'
                                      init_button_text_first='<?=$slider->button_text_first?>'
                                      init_button_link_first='<?=$slider->button_link_first?>'
                                      init_button_text_second='<?=$slider->button_text_second?>'
                                      init_button_link_second='<?=$slider->button_link_second?>'
                                      init_is_featured='<?=(boolean)$slider->is_featured?>'
                                      image_preview='<?=base_url('/uploads/sliders/').$slider->id.'_'.$slider->image_name?>'
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
