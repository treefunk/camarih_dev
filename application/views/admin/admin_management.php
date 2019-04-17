<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Admin List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <button data-toggle="modal" data-target="#addAdminModal" class="btn btn-success btn-s"> Create New Admin</button>
                      </span>
                  </header>
                  <div class="panel-body">
                  <?php require_once "partials/alert.php"; ?> 
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
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($admins as $admin): ?>
                    <tr>
                        <td><?=$admin->username?></td>
                        <td><?=$admin->created_at?></td>
                        <td>
                            <a data-toggle="modal" href="#editAdmin"
                            data-payload='<?=json_encode($admin)?>'
                            data-url='<?=base_url('admin/editAdmin/')?>'
                            >
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i></button>
                            </a>

                            <a data-toggle="modal" href="#deleteAdmin"
                            data-payload='<?=json_encode($admin)?>'
                            data-url='<?=base_url('admin/deleteAdmin/')?>'>
                                <button class="btn btn-danger btn-s"><i class="fa fa-trash-o"></i></button>
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

<?php require_once "modals/add.php"; //Add modal here ?> 
<?php require_once "modals/edit.php"; //Edit modal here ?>
<?php require_once "modals/delete.php"; //Edit modal here ?>

<?php //todo change password ?>
