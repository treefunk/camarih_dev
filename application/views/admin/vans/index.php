<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading">
                      Van List
                      <span class="pull-right">
                          <!-- <button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button> -->
                          <a href="<?=base_url('vans/create')?>">
                            <button class="btn btn-success btn-s"> Create New Van</button>
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
                        <th>Description</th>
                        <th>Seat Map</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($vans as $van): ?>
                    <tr>
                        <td><?=$van->name?></td>
                        <td style="max-width: 350px; word-wrap: break-word"><?=shortVer($van->description,200)?></td>
                        <td><?=$van->seat_map?></td>
                        <td><?=$van->created_at?></td>
                        <td>
                            <a href="<?=base_url("vans/rates/{$van->id}")?>">
                                <button class="btn btn-default btn-s">Rates <i class="fa fa-road"></i></button>                                
                            </a>
                            <a href="<?=base_url('vans/edit/').$van->id?>">
                                <button class="btn btn-info btn-s"><i class="fa fa-pencil"></i></button>
                            </a>
                            

                            <a data-toggle="modal" href="#deleteVan"
                            data-payload='<?=json_encode($van)?>'
                            data-url='<?=base_url('vans/delete/')?>'>
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
