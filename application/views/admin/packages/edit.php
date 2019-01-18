

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="panel-cs">
            <div class="panel-body">
                              <div class="stepy-tab"><ul id="default-titles" class="stepy-titles clearfix"><li id="default-title-0" class="current-step"><div>Overview</div><span> </span></li><li id="default-title-1" class=""><div>Package Gallery</div><span> </span></li><li id="default-title-2" class=""><div>Step 3</div><span> </span></li></ul></div>
                              <form form role="form" method="POST" action="<?=base_url("tourpackages/update/{$package->id}")?>" enctype="multipart/form-data" class="form-horizontal" id="default">
                                  <fieldset title="Overview" class="step" id="default-step-0" style="display: block;">
                                <legend></legend>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?=$package->name?>">
                                </div>
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="text" class="form-control" id="rate" placeholder="Enter rate" name="rate" value="<?=$package->rate?>">
                                </div>

                                <div class="form-group">

                                    <label for="description">Description</label>

                                    <textarea name="description" class="form-control" id="inputdescription" class="form-control" rows="9"><?=$package->package_details->description?></textarea>
                                </div>

                                

                                </fieldset>


                                  <fieldset title="Gallery" class="step" id="default-step-1" style="display: none;">
                                      <legend> </legend>

                                    <!-- current images here -->

                                    
                                    <create-package-form
                                    :packagegallery_data="<?=json_encode($package->package_gallery)?>"
                                    ></create-package-form>

                                      
                                      <div class="form-group">
                                    <label for="gallery">Add Image/s</label>
                                    <input type="file" name="images[]" id="add_images" multiple>
                                </div>

                                

                                      
                                      
                                    </fieldset>
                                    <button type="submit" class="finish btn btn-success">Create</button>
                                  
                              </form>
        </div>
        </div>
</section>


