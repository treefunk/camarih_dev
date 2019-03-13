<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Slider List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('sliders/create')?>">
                            <button class="btn btn-success btn-s"> Create New Slider</button>
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
                        <th>Header</th>
                        <th>Sub Header</th>
                        <th>Buttons</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($sliders as $slider): ?>
                    <tr>
                        <td><?=$slider->image_name?></td>
                        <td><?=$slider->header?></td>
                        <td><?=$slider->sub_header?></td>
                        <td>
                            <?php if($slider->button_text_first != ''): ?>
                                Text: <?=$slider->button_text_first?> Link: <?=$slider->button_link_first?> 
                            <?php endif; ?>
                            <?php if($slider->button_text_second != ''): ?>
                            <br>
                                Text: <?=$slider->button_text_second?> Link: <?=$slider->button_link_second?> 
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?=base_url('sliders/edit/').$slider->id?>">
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i> Edit </button>
                            </a>

                            <a data-toggle="modal" href="#deleteSlider"
                            data-payload='<?=json_encode($slider)?>'>
                                <button class="btn btn-danger btn-s"><i class="fa fa-trash-o"></i> Delete </button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                  <div class="pagination">
                      <?= $links ?>
                  </div>
              </section>
              <!-- page end-->
          </section>
</section>

<?php //require_once "modals/add.php"; //Add modal here ?> 
<?php //require_once "modals/edit.php"; //Edit modal here ?>
<?php require_once "modals/delete.php"; //Edit modal here ?>
