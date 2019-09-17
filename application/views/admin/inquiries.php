<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Tour Inquiry List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <!-- <button data-toggle="modal" data-target="#addAdminModal" class="btn btn-success btn-s"> Create New Admin</button> -->
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
                        <th>Package</th>
                        <th>Contact #</th>
                        <th>Email</th>
                        <th>Date Inquired</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      <?php if ($inquiries): ?>
                        <?php foreach($inquiries as $inquiry): ?>
                        <tr>
                            <td><?=$inquiry->name?></td>
                            <td><?=$inquiry->package_name?></td>
                            <td><?=$inquiry->mobile?></td>
                            <td><a href="mailto:<?=$inquiry->email_address?>"><?=$inquiry->email_address?></a></td>
                            <td><?=$inquiry->created_at?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                      <?php endif ?>
                    </tbody>
                  </table>
                  <div class="text-center">
                      <div class="pagination">
                          <?php echo $links ?>
                      </div>
                  </div>
              </section>
              <!-- page end-->
          </section>
</section>