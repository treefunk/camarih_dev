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
                                      <form role="form" action="<?=base_url('tripschedule/update')?>" method="POST" enctype="multipart/form-data">
                                          
                                        <schedule-form
                                        :schedules_data='<?=json_encode($schedules)?>'
                                        >

                                        </schedule-form>
                                          


                                    <button type="submit" class="btn_orange right_btn">Save Changes</button>

                                      </form>
        
                            </div>

                      </div>
                  </div>


              </section>
              <!-- page end-->
          </section>
</section>