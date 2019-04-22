<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel panel-pad">
                  <header class="panel-heading">
                      Van Reservations
                  </header>
                  <div class="panel-body">
                  <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  </div>
                  <form action="<?=base_url('van-reservations')?>" method="GET">
                  <div class="row" style="margin-bottom:15px">
                        <div class="col-md-4">
                              <label for="filter_package">Search</label>
                              <input type="text" name="search" value="<?=isset($get['search']) ? $get['search'] : ''?>"  class="form-control">
                                </select>
                          </div>
                          <div class="col-md-4">
                             <label for="filter_origin">Filter Van</label>
                            <select class="form-control" name="van_id">
                            <option value="">Select Van</option>
                            <?php foreach($vans as $van): ?>
                            <option value="<?=$van->id?>"  <?=$this->input->get('van_id') == $van->id ? "selected" : ""?>><?=$van->name?></option>
                            <?php endforeach; ?>

                            </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter_origin">Filter Destination</label>
                                <select class="form-control" name="destination_id">
                                    <option value="">Select Destination</option>
                                    <?php foreach($destinations as $destination): ?>
                                    <option value="<?=$destination->id?>" <?=$this->input->get('destination_id') == $destination->id ? "selected" : ""?>><?=$destination->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                  </div>
                      <div class="row">
                      <!-- FILTERS ! -->
                      
                        <div class="col-md-4">
                            <label for="filter_origin">Departure Date range</label>
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input autocomplete="off" type="text" class="form-control datepicker" name="departure_start" value="<?= isset($get['departure_start']) ? $get['departure_start'] : "" ?>">
                                <span class="input-group-addon">To</span>
                                <input autocomplete="off" type="text" class="form-control datepicker" name="departure_end" value="<?= isset($get['departure_end']) ? $get['departure_end'] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="filter_origin">Filter Trip Type</label>
                            <select class="form-control" name="trip_type">
                            <option value="">Select Trip Type</option>
                            <?php foreach($trip_types as $trip): ?>
                                <option value="<?=$trip?>"  <?=$this->input->get('trip_type') == $trip ? "selected" : ""?>><?=ucFirst(str_replace('_'," ",$trip))?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filter_origin">Filter Status</label>
                            <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <?php foreach($status_types as $status): ?>
                            <option value="<?=$status?>"  <?=$this->input->get('status') == $status ? "selected" : ""?>><?=ucFirst($status)?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                        <div class="row" style="margin: 30px 30px;">
                            <div class="col-md-offset-3">
                                <div class="col-md-1 col-md-offset-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <a href="<?=base_url('van-reservations')?>">
                                                <button class="btn btn-info" type="button"
                                                    name="clearfilters">Clear</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                  <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Van Name
                        </th>
                        <th>
                            Origin Name
                        </th>
                        <th>
                            Destination Name
                        </th>
                        <th>
                            Departure Date
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Trip Type
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Created At 
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($van_reservations as $van_reservation): ?>
                            <tr>
                                <td><?=$van_reservation->fullname?></td>
                                <td><?=$van_reservation->van_name?></td>
                                <td><?=$van_reservation->origin_name?></td>
                                <td><?=$van_reservation->destination_name?></td>
                                <td><?=format_datetime_string($van_reservation->departure_date,'M j, Y')?></td>
                                <td><?=$van_reservation->price?></td>
                                <td><?=ucFirst(str_replace('_'," ",$van_reservation->trip_type))?></td>
                                <td><?=$van_reservation->status?></td>
                                <td><?=$van_reservation->created_at?></td>
                                <td>
                                <a data-toggle="modal" href="#statusModal"
                                        data-payload='<?=json_encode(['id' =>$van_reservation->id,'status' => $van_reservation->status,'form_url' => base_url("van_reservations/updatestatus/{$van_reservation->id}")])?>'>
                                        <button class="btn btn-warning btn-s"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    <a data-toggle="modal" href="#detailsModal"
                                        data-payload='<?=json_encode(['van_reservation' => $van_reservation,'url' => base_url('van_reservations/getVanDetails')])?>'>
                                        <button class="btn btn-info btn-s"><i class="fa fa-eye"></i></button>
                                    </a>
                                </td>
                            </tr>   
                            <?php endforeach; ?>
                    </tbody>
                  </table>
                  <div class="text-center">
                      <div class="pagination">
                          <?=$links ?>
                      </div>
                  </div>
              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/delete.php"; //Edit modal here ?>
<?php require_once "modals/view_details.php"; ?>
<?php require_once "modals/update_status.php"; ?>
<script>
$('.datepicker').datepicker();




</script>