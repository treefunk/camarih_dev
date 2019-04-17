<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Package Reservations
                  </header>
                  <div class="panel-body">
                  <?php require_once __DIR__. "/../partials/alert.php"; ?> 
                  </div>
                  <div class="row">
                      <form action="<?=base_url('package-reservations')?>" method="GET">
                      <!-- FILTERS ! -->
                      <div class="col-md-offset-2">
                        <div class="col-md-3">
                              <label for="filter_package">Search</label>
                              <input type="text" name="search" value="<?=isset($get['search']) ? $get['search'] : ''?>"  class="form-control">
                                </select>
                          </div>
                          <div class="col-md-3">
                              <label for="filter_package">Filter Package Name</label>
                              <select class="form-control" name="package_id">
                                  <option value="">Select Package</option>
                                <?php foreach($packages as $package): ?>
                                <option value="<?=$package->id?>" <?=$this->input->get('package_id') == $package->id ? "selected" : ""?>><?=$package->name?></option>
                                <?php endforeach; ?>
                                </select>
                          </div>
                            <div class="col-md-3">
                                <label for="filter_origin">Filter Status</label>
                                <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <?php foreach($status_types as $status): ?>
                                <option value="<?=$status?>"  <?=$this->input->get('status') == $status ? "selected" : ""?>><?=ucFirst($status)?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>

                      </div>
                        <div class="col-md-offset-10">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <a href="<?=base_url('package-reservations')?>">
                                            <button class="btn btn-info" type="button"
                                                name="clearfilters">Clear</button>
                                        </a>
                                    </div>
                                </div>
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
                        <th>Full Name</th>
                        <th>Package Name</th>
                        <th>Adult Count</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>
                            Created At 
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($package_reservations as $package_reservation): ?>
                        <tr>
                            <td><?=$package_reservation->fullname?></td>
                            <td><?=$package_reservation->package_name?></td>
                            <td><?=$package_reservation->adult_count?></td>
                            <td><?=$package_reservation->price?></td>
                            <td><?=$package_reservation->status?></td>
                            <td><?=$package_reservation->created_at?></td>
                            <td>
                                <a data-toggle="modal" href="#statusModal"
                                    data-payload='<?=json_encode(['id' =>$package_reservation->id,'status' => $package_reservation->status,'form_url' => base_url("package_reservations/updatestatus/{$package_reservation->id}")])?>'>
                                    <button class="btn btn-warning btn-s"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a data-toggle="modal" href="#detailsModal"
                                    data-payload='<?=json_encode(['package_reservation' => $package_reservation,'url' => base_url('package_reservations/getPackageDetails')])?>'>
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