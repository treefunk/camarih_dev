<div class="packages-selected">


        <section class="sec-1">
          <article class="hero">
              <h3><?=$package->name?></h3>
              <p>Tour Package</p>
          </article>
          <div class="overlay"></div>

        </section>
          


        <book-a-trip
        url='<?=base_url('availability/check')?>'
        :destinations_data='<?=json_encode($destinations)?>'
        :origins_data='<?=json_encode($origins)?>'
        > </book-a-trip>

        <section class="sec-2">
          <div class="itemhldr">
            
            <article class="dvider">
              <aside>
              <!-- <?php //base_url('frontend')?>/images/rocks.jpg -->
              <?php if($package->package_image): ?>
                <img src="<?=base_url("uploads/package_image/{$package->package_image->id}_{$package->package_image->image_name}")?>">
              
              <?php else: ?>
                <img src=" <?= base_url('frontend')?>/images/rocks.jpg" alt="">
              <?php endif; ?>
              </aside>
              
              <article>
                  <div class="pad-0">
                    <?=$package->package_details->description?>
                  </div>
              </article>
              
            </article>
            
              <selected-package-form
              :package_data='<?=json_encode($package)?>'
              add_to_cart_url='<?=base_url('packages/add_to_cart')?>  '
              ></selected-package-form>

            </div>
            
          
        </section>


<?php if(count($package->package_gallery)): ?>
<section class="sec-3">
    <article class="item-hldr">
        <h3>Tourist Attractions</h3>
        <div class="owl-carousel owl-theme slct-pckge owl-loaded owl-drag">
            <?php foreach($package->package_gallery as $image): ?>
            <div>
                <aside>
                    <img src="<?=base_url("uploads/package_gallery/{$package->id}_{$image->image_name}")?>">
                </aside>
                <article>
                    <h4><?=$image->image_title?></h4>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>
<?php endif; ?>
    
<?php if($package->package_download){
  require_once("package_view_download_modal.php");
} ?>
        
</div>