<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      <?=$van->name?> Rates
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>                      
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                    <create-van-rate-form
                    :destinations_data='<?=json_encode($destinations)?>'
                    :origins_data='<?=json_encode($origins)?>'
                    form_url="<?=base_url("vans/updaterates/{$van->id}")?>"
                    :van_rates_data='<?=json_encode($van->van_rates)?>'
                    ></create-van-rate-form>
    
                  </div>


              </section>
              <!-- page end-->
          </section>
</section>
<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php //require_once "modals/delete.php"; //Edit modal here ?>

