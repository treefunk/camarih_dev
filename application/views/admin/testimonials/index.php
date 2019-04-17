<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Testimonial List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('testimonials/create')?>">
                            <button class="btn btn-success btn-s"> Create New Testimonial</button>
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
                        <th>Image</th>
                        <th>Title</th>
                        <th>Testimonial</th>
                        <th>Name</th>
                        <th>Occupation</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($testimonials as $testimonial): ?>
                    <tr>
                        <td><?=$testimonial->image_name?></td>
                        <td><?=$testimonial->title?></td>
                        <td style="max-width: 350px"><?=shortVer($testimonial->testimonial,200)?></td>
                        <td><?=$testimonial->name?></td>
                        <td><?=$testimonial->occupation?></td>
                        <td>
                                <a href="<?=base_url('testimonials/edit/').$testimonial->id?>">
                                    <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a data-toggle="modal" href="#deleteTestimonial"
                                data-payload='<?=json_encode(array_merge((array)$testimonial,["url" => base_url("testimonials/delete/")]))?>'>
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

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php require_once "modals/delete.php"; //Edit modal here ?>

