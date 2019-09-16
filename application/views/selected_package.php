<div class="packages-selected">

  <section class="sec-1">
    <article class="hero">

      <h3><?php  echo $is_day_tour_format  ?></h3>
    </article>
    <div class="overlay"></div>

  </section>

  <book-a-trip
  url='<?=base_url('availability/check')?>'
  :destinations_data='<?=json_encode($destinations)?>'
  :origins_data='<?=json_encode($origins)?>'
  > </book-a-trip>

  <!-- <section class="sec-2">

    <div class="itemhldr">
      <h3><?=$package->name?></h3>
      <article class="dvider">
        <aside>
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
            <div class="item">
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
  } ?> -->

</div>
<div class="pagewrapper3" style="margin-top: 200px;">
  <?php if(isset($_SESSION['alert']['type'])): ?>
    <div class="alert alert-<?=$_SESSION['alert']['type']?> alert-block fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        <?php $type = $_SESSION['alert']['type']; ?>

        <?php if(in_array($type,['success','danger'])): ?>
        <h4>
            <i class="fa fa-ok-sign"></i>
            <?php
                
                if($type == 'success'){
                    echo "Success!";
                }elseif($type == 'info'){
                    echo "";
                }else{
                    echo "Error";
                }
            ?>
        </h4>
        <?php endif; ?>
          <p style="margin-left: 5px;margin-top: 11px;"><?=$_SESSION['alert']['message']?></p>
    </div>

  <?php endif; ?>
 <!-- Content for Selected Day Tour -->
  <section class="tour-content">
    <article class="tour-overview">
      <h2><?=$package->name?></h2>
     
      <h5><?php echo $package->location_name ?></h5>
      <?php if (isset($package->package_details->price_description)): ?>
        <?php $package_desc = explode('</p><p>', $package->package_details->price_description); ?>
        <h4><?php echo strip_tags($package_desc[0])?><br>
          <?php unset($package_desc[0]); ?>
          <span><?php echo implode(" ",$package_desc) ?></span>
        </h4>
      <?php endif ?>
    </article>

    <?php if(count($package->package_gallery)): ?>
      <article class="tour-highlights">
       <h3>Tour Highlights</h3>
       <?php echo $package->package_details->description; ?>
       <p style="margin-bottom: 30px;"></p>
       <div class="highlights gallery-item">
          <?php foreach($package->package_gallery as $image): ?>
            <div class="item">
              <a href="<?=base_url("uploads/package_gallery/{$package->id}_{$image->image_name}")?>">
                <div class="thumb"><img src="<?=base_url("uploads/package_gallery/{$package->id}_{$image->image_name}")?>" title="<?=$image->image_title?>"></div>
                <span><?=$image->image_title?></span>
              </a>
            </div>
          <?php endforeach; ?>
          
        </div>
      </article>
    <?php endif;?>
    <?php if ($package->package_itineraries): ?>
      <article class="itinerary">
       <h3>Itinerary<span>*</span></h3>
       <ul class="itinerary-list">
         <?php foreach ($package->package_itineraries as $key => $itinerary): ?>
           <li>
             <h4>
               <label><?php echo $itinerary->title ?></label>
               <span><?php echo $itinerary->time ?></span>
             </h4>
             <p><?php echo $itinerary->description ?></p>
           </li>
         <?php endforeach ?>
       </ul>
      </article>
    <?php endif ?>

    <?php if ($package->package_accomodations): ?>
      <article class="accomodations" style="padding-bottom: 0px; margin-bottom: 30px;">
       <div class="hldr" style="width: 100%; padding: 30px 0px; border-top: 2px solid #d5d5d5;  border-bottom: 2px solid #d5d5d5;">
         <h3>Accommodation</h3>
         <ul>
            <?php foreach ($package->package_accomodations as $key => $accomodation): ?>
              <li>
                  <label><?php echo $accomodation->title ?></label> 
                  <?php echo $accomodation->description ?>
              </li>
            <?php endforeach ?>
         </ul>
       </div>
      </article>
    <?php endif ?>

    <?php if (isset($package->package_details->exclusions) || isset($package->package_details->inclusions)): ?>
      <article class="inclusions-exclusions">
        <?php if ($package->package_details->inclusions): ?>
          <div class="col2">
            <h3>Inclusions</h3>
            <?php echo $package->package_details->inclusions; ?>
          </div>
        <?php endif ?>
        <?php if ($package->package_details->exclusions || $package->package_details->booking_conditions): ?>
          <div class="col2">
            <?php if ($package->package_details->exclusions): ?>
              <h3>Exclusions</h3>
              <?php echo $package->package_details->exclusions; ?>
            <?php endif ?>
          </div>
        <?php endif ?>

        <?php if ($package->package_details->exclusions || $package->package_details->booking_conditions): ?>
          <div class="col2">
            <?php if ($package->package_details->booking_conditions): ?>
              <h3>Booking Conditions</h3>
              <?php echo $package->package_details->booking_conditions; ?>
            <?php endif ?>
          </div>
        <?php endif ?>

      </article>
    <?php endif ?>
  </section>
</div>
  <selected-package-form
    :package_data='<?=json_encode($package, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)?>'
    add_to_cart_url='<?=base_url('packages/add_to_cart')?>  '
    form_url="<?=base_url("packages/sendInquiry/{$package->id}")?>"
  ></selected-package-form>
<!-- <div class="packages-selected">

  <section class="sec-1">
    <article class="hero">

      <h3>Tour Package</h3>
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
      <h3><?=$package->name?></h3>
      <article class="dvider">
        <aside>
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
            <div class="item">
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

</div> -->