<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Edit Van
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-12">

                            <create-van-form
                          create_van_url=<?=base_url("vans/update/{$van->id}")?>
                          :van_seats_data='<?=json_encode($van->seatmap)?>'
                          :van_gallery_existing='<?=json_encode($van->van_gallery)?>'
                          van_gallery_url=<?=base_url('uploads/van_gallery')?>
                          :van_data='<?=json_encode($van)?>'
                          />

                      </div>
                  </div>


              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php //require_once "modals/delete.php"; //Edit modal here ?>

