<section id="main-content" class="app">
          <section class="wrapper site-min-height">
              
              <!-- page start-->
              <section class="panel-cs">
                  <header class="panel-heading">
                      Schedule
                      
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                      </span>
                  </header>
                  <p> <b>PPS</b> - Puerto Princesa </p>
               <p> <b>ELN</b> - El Nido </p>                    
                    <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  <div class="row">
                      <div class="col-md-12">
                          
                          <div class="panel-body">
                                          
                                        <schedule-form
                                        :schedules_data='<?=json_encode($schedules)?>'
                                        action_url='<?=base_url('tripschedule/update')?>'
                                        schedule_text="<?=$body?>"
                                        >

                                        </schedule-form>
                                          


                                    
        
                            </div>

                      </div>
                  </div>


              </section>
              <!-- page end-->
          </section>
</section>