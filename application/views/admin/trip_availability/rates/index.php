<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                        <h3>Rate List</h3>
                      <div>
                          <strong>Departure Date and Time:</strong>
                          <?=format_datetime_string($trip_availability->departure_date,'M j Y h:i A')?>
                      </div>
                      <div>
                          <strong>Origin:</strong>
                          <?=$trip_availability->origin->name?> (<?=$trip_availability->origin->short_name?>)
                      </div>
                      <div>
                          <strong>
                              Selling Date:
                          </strong>
                          <?=format_datetime_string($trip_availability->selling_start,'M j Y')?> - <?=format_datetime_string($trip_availability->selling_end,'M j Y')?>
                      </div>
                      <div>
                          <strong>
                              Type:
                          </strong>
                          <?=!$trip_availability->is_roundtrip ? 'One-way trip' : 'Roundtrip' ?>
                      </div>

                      
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('trip_availability/edit/'.$trip_availability->id)?>">
                            <button class="btn btn-success btn-s">Edit Trip Availability</button>
                          </a>
                      </span>
                  </header>
                  <div class="panel-body">
                  <?php require_once __DIR__. "/../../partials/alert.php"; ?> 
                      <div class="row">
                          <!-- filters goes here -->

                          <!-- <div class="col-md-4 pull-right">
                              <div class="input-group"><input type="text" placeholder="Search Here" class="input-sm form-control"> <span class="input-group-btn">
                              <button type="button" class="btn btn-sm btn-success"> Go!</button> </span></div>
                          </div> -->
                      </div>
                  </div>
                  <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Price</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($trip_availability->rates as $rate): ?>
                    <tr>
                        <td><?=$rate->name?></td>
                        <td>&#8369;<?=number_format($rate->price,2)?></td>
                        <td><?=$rate->created_at?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php //require_once "modals/delete.php"; //Edit modal here ?>
