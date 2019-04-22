<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel panel-pad">
                  <header class="panel-heading">
                      Booking Reservations
                  </header>
                  <div class="panel-body">
                  <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  </div>
                  <form action="<?=base_url('booking_reservations')?>" method="GET">
                  <div class="row" style="margin-bottom:15px">
                        <div class="col-md-4">
                              <label for="filter_package">Search</label>
                              <input type="text" name="search" value="<?=isset($get['search']) ? $get['search'] : ''?>"  class="form-control">
                                </select>
                          </div>
                          <div class="col-md-4">
                              <label for="filter_origin">Filter Origin</label>
                              <select class="form-control" name="origin_id">
                                  <option value="">Select Origin</option>
                                <?php foreach($origins as $origin): ?>
                                <option value="<?=$origin->id?>" <?=$this->input->get('origin_id') == $origin->id ? "selected" : ""?>><?=$origin->name?></option>
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
                             <label for="filter_origin">Filter Van</label>
                            <select class="form-control" name="van_id">
                            <option value="">Select Van</option>
                            <?php foreach($vans as $van): ?>
                            <option value="<?=$van->id?>"  <?=$this->input->get('van_id') == $van->id ? "selected" : ""?>><?=$van->name?></option>
                            <?php endforeach; ?>

                            </select>
                      </div>
                        <div class="col-md-4">
                            <label for="filter_origin">Departure Date range</label>
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input autocomplete="off" type="text" class="form-control datepicker" name="departure_start" value="<?= isset($get['departure_start']) ? $get['departure_start'] : "" ?>">
                                <span class="input-group-addon">To</span>
                                <input autocomplete="off" type="text" class="form-control datepicker" name="departure_end" value="<?= isset($get['departure_end']) ? $get['departure_end'] : "" ?>">
                            </div>
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
                                            <a href="<?=base_url('booking_reservations')?>">
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
                            Origin
                        </th>
                        <th>
                            Destination
                        </th>
                        <th>
                            Van
                        </th>
                        <th>
                            Departure Date & Time
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
                        <?php foreach($booking_reservations as $booking): ?>
                        <tr>
                            <td><?=$booking->fullname?></td>
                            <td><?=$booking->origin_name?></td>
                            <td><?=$booking->destination_name?></td>
                            <td><?=$booking->van_name?></td>
                            <td><?=format_datetime_string($booking->departure_date,'M j, Y h:ia')?></td>
                            <td><?=ucFirst($booking->status)?></td>
                            <td><?=$booking->created_at?></td>
                            <td>
                                <a data-toggle="modal" href="#statusModal"
                                    data-payload='<?=json_encode(['id' =>$booking->id,'status' => $booking->status,'form_url' => base_url("booking_reservations/updatestatus/{$booking->id}")])?>'>
                                    <button class="btn btn-warning btn-s"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a data-toggle="modal" href="#detailsModal"
                                    data-payload='<?=json_encode(['booking' => $booking,'url' => base_url('booking_reservations/getBookingDetails')])?>'>
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

<?php require_once "modals/update_status.php"; ?>
<?php require_once "modals/view_details.php"; ?>

<script>
$('.datepicker').datepicker();




</script>