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
                  <div class="row">
                      <form action="<?=base_url('trip_availability')?>" method="GET">
                      <!-- FILTERS ! -->
                      <div class="col-md-4">
                          <label for="filter_origin">Filter Origin</label>
                          <select class="form-control" name="origin_id">
                              <option value="">Select Origin</option>
                                <?php foreach($origins as $origin): ?>
                                    <option value="<?=$origin->id?>" <?= isset($get['origin_id']) && $get['origin_id'] == $origin->id ? "selected" : "" ?>><?=$origin->name?></option>
                                <?php endforeach; ?>
                            </select>
                      </div>
                      <div class="col-md-4">
                      <label for="filter_origin">Filter Van</label>
                            <select class="form-control" name="van_id">
                            <option value="">Select Van</option>
                                <?php foreach($vans as $van): ?>
                                    <option value="<?=$van->id?>" <?= isset($get['van_id']) && $get['van_id'] == $van->id ? "selected" : "" ?>><?=$van->name?></option>
                                <?php endforeach; ?>
                            </select>
                      </div>
                        <div class="col-md-3">
                        <label for="filter_origin">Selling Date range</label>
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input autocomplete="off" type="text" class="form-control datepicker" name="selling_start" value="<?= isset($get['selling_start']) ? $get['selling_start'] : "" ?>">
                                <span class="input-group-addon">To</span>
                                <input autocomplete="off" type="text" class="form-control datepicker" name="selling_end" value="<?= isset($get['selling_end']) ? $get['selling_end'] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="form-group">
                                    <a href="<?=base_url('trip_availability')?>">
                                            <button class="btn btn-info" type="button" name="clearfilters">Clear</button>
                                    </a>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-default" type="submit">Filter</button>                                
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
                  <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            Origin
                        </th>
                        <th>
                            
                            Van
                        </th>
                        <th>
                            Selling Date Availability
                        </th>
                        <th>
                            Created At 
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    
                    <tbody>
                    <?php foreach($trips as $trip_availability): ?>
                    <tr>
                        <td><?=$trip_availability->origin_name?></td>
                        <td><?=$trip_availability->van_name?></td>
                        <td><?=format_datetime_string($trip_availability->selling_start,'M j Y')?> - <?=format_datetime_string($trip_availability->selling_end,'M j Y')?></td>
                        <td><?=$trip_availability->created_at?></td>
                        <td>
                            <a href="<?=base_url("trip_availability/rates/").$trip_availability->id?>"><button class="btn btn-info">View Rates</button></a>
                            <a href="<?=base_url("trip_availability/edit/").$trip_availability->id?>">
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i> Edit </button>
                            </a>

                            <a data-toggle="modal" href="#deleteTripAvailability"
                            data-payload='<?=json_encode(['id' =>$trip_availability->id])?>'>
                                <button class="btn btn-danger btn-s"><i class="fa fa-trash-o"></i> Delete </button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                  <div class="pagination">
                      <?=$links?>
                  </div>
              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php require_once "modals/delete.php"; //Edit modal here ?>
<script>
$('.datepicker').datepicker();
</script>