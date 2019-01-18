<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Package List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('tourpackages/create')?>">
                            <button class="btn btn-success btn-s"> Create New Package</button>
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
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($packages as $package): ?>
                    <tr>
                        <td><?=$package->name?></td>
                        <td><?=$package->rate?></td>
                        <td><?=$package->status?></td>
                        <td><?=$package->created_at?></td>
                        <td>
                            <a href="<?=base_url('tourpackages/edit/').$package->id?>">
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i> Edit </button>
                            </a>

                            <a data-toggle="modal" href="#deletePackage"
                            data-payload='<?=json_encode($package)?>'>
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
