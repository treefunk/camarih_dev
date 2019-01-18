<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Trip Availability List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('trip_availability/create')?>">
                            <button class="btn btn-success btn-s"> Create New Trip Availability</button>
                          </a>
                      </span>
                  </header>
                  <div class="panel-body">
                  <?php require_once __DIR__. "/../partials/alert.php"; ?> 
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
                        <th>Departure Date</th>
                        <th>Origin</th>
                        <th>Van</th>
                        <th>Selling Date Availability</th>
                        <th>Roundtrip</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($trips as $trip_availability): ?>
                    <tr>
                        <td><?=format_datetime_string($trip_availability->departure_date,'M j Y h:i A')?></td>
                        <td><?=$trip_availability->origin->name?></td>
                        <td><?=$trip_availability->van->name?></td>
                        <td><?=format_datetime_string($trip_availability->selling_start,'M j Y')?> - <?=format_datetime_string($trip_availability->selling_end,'M j Y')?></td>
                        <td><?=$trip_availability->is_roundtrip ? "Yes" : "No" ?></td>
                        <td><?=$trip_availability->created_at?></td>
                        <td>
                            <a href="<?=base_url("trip_availability/rates/").$trip_availability->id?>"><button class="btn btn-info">View Rates</button></a>
                            <a href="<?=base_url("trip_availability/edit/").$trip_availability->id?>">
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i> Edit </button>
                            </a>

                            <a data-toggle="modal" href="#deleteTripAvailability"
                            data-payload='<?=json_encode($trip_availability)?>'>
                                <button class="btn btn-danger btn-s"><i class="fa fa-trash-o"></i> Delete </button>
                            </a>
                        </td>
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
