<div class="home">

<section class="sec-1">
  <div class="owl-carousel owl-theme home-carousel">
    <?php foreach($sliders as $slider): ?>
    <div class="item">
      <div class="overlay"></div>
      <aside>
        <img src="<?=base_url()?>uploads/sliders/<?=$slider->id?>_<?=$slider->image_name?>">
      </aside>

      <article class="text-hldr">
        <h3><?=$slider->header?></h3>
        <p><?=$slider->sub_header?></p>

        <ul class="pad-0 listn">
          <?php if($slider->button_text_first): ?>
          <li>
            <a href="<?=$slider->button_link_first?>"><?=$slider->button_text_first?></a>
          </li>
          <?php endif; ?>

          <?php if($slider->button_text_second): ?>
          <li>
            <a href="<?=$slider->button_link_second?>"><?=$slider->button_text_second?></a>
          </li>
          <?php endif; ?>
        </ul>
      </article>
      
    </div>
  <?php endforeach; ?>
  </div>

</section>



  <book-a-trip
  url='<?=base_url('availability/check')?>'
  :destinations_data='<?=json_encode($destinations)?>'
  :origins_data='<?=json_encode($origins)?>'
  > </book-a-trip>


<section class="sec-2">

        <!-- <div class="packages"> -->
          <!-- <single-package
          :item='<?php //json_encode($featured_package)?>'
          :key="1" 
          :index="1"
          single_url="<?php //base_url('packages/selected')?>"
          add_to_cart_url="<?php //base_url('packages/add_to_cart')?>"
          ></single-package>
           -->
        <!-- </div> -->
        <?php if($featured_package): ?>
          <featured-package
          :package_data='<?=json_encode($featured_package)?>'
          single_url="<?=base_url('packages/selected')?>"
          add_to_cart_url="<?=base_url('packages/add_to_cart')?>"
          view_all_url="<?=base_url('packages')?>"
          main_image_url="<?=base_url($this->packageimage_model->upload_path)?>"
          ></featured-package>
        <?php endif; ?>
</section>

<?php if(count($testimonials)) : ?>
<section class="sec-3">
    <div class="owl-carousel owl-theme testi-carou">

      <?php foreach($testimonials as $testimonial): ?>
                    <div class="item">
                      <article class="text-hldr">
                        <h4>Testimonials</h4>
                        <h3>What they say about us</h3>
                        <h5><?=$testimonial->title?></h5>

                        <p><?=$testimonial->testimonial?></p>
                        <div class="img-hldr">
                          <aside>
                            <img src="<?=base_url()?>uploads/testimonials/<?=$testimonial->id?>_<?=$testimonial->image_name?>">
                          </aside>
                          <article>
                            <h4><?=$testimonial->name?></h4>
                            <h5><?=$testimonial->occupation?></h5>
                          </article>
                        </div>
                      </article>
                    </div>      
      <?php endforeach; ?>
      

    </div>
</section>
<?php endif; ?>


</div>