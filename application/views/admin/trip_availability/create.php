<section id="main-content">
          <section class="wrapper site-min-height app">
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Create Trip Availability
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-12">
                          
                          <div class="panel-body">
                                        <?php //base_url/resources/js/components/TripAvailabilityForm.vue ?>
                                        <trip-availability-form
                                        :vans='<?=json_encode($vans)?>'
                                        :destinations_data='<?=json_encode($destinations)?>'
                                        :origins_data='<?=json_encode($origins)?>'
                                        post_url='<?=base_url('trip_availability/store')?>'
                                        />
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

<script>


</script>