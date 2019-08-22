<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Package Name List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <button data-toggle="modal" data-target="#addAdminModal" class="btn btn-success btn-s"> Create New Package Name</button>
                      </span>
                  </header>
                  <div class="panel-body">
                  <?php require_once "alert.php"; ?> 
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
                        <th>Sub-Directory of</th>
                        <th>Duration</th>
                        <!-- <th>Status</th> -->
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if ($labels): ?>
                        <?php foreach($labels as $tour_category): ?>
                        <tr>
                            <td><?=$tour_category->name?></td>
                            <td><?php echo $tour_category->is_sub_directory_format; ?></td>
                            <td><?=$tour_category->duration_format?></td>
                            <!-- <td><?=$tour_category->status?></td> -->
                            <td><?=$tour_category->created_at?></td>
                            <td>
                                <a data-toggle="modal" href="#editPackageName"
                                data-payload='<?=json_encode($tour_category)?>'
                                data-url='<?php #echo base_url('admin/editAdmin/')?>'
                                >
                                    <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i></button>
                                </a>

                                <a data-toggle="modal" href="#deletePackageName"
                                data-payload='<?=json_encode($tour_category)?>'
                                data-url='<?php echo base_url('tourpackages/delete_package_label/')?>'>
                                    <button class="btn btn-danger btn-s"><i class="fa fa-trash-o"></i></button>
                                </a>


                                
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                      <?php endif ?>
                    </tbody>
                  </table>
                  <div class="text-center">
                      <div class="pagination">
                          <?= @$links ?>
                      </div>
                  </div>
              </section>
              <!-- page end-->
          </section>
</section>

<?php require_once "modals/add-package-label.php"; //Add modal here ?> 
<?php require_once "modals/edit-package-label.php"; //Edit modal here ?>
<?php require_once "modals/delete-package-label.php"; //Edit modal here ?>

<?php //todo change password ?>
