<div class="packages-selected">

        <section class="sec-1">
          <article class="hero">
              <h3><?=$package->name?></h3>
              <p>Tour Package</p>
          </article>
          <div class="overlay"></div>

        </section>


        <form action="<?=base_url()?>availability/check" method="POST">
            <book-a-trip
            :destinations='<?=json_encode($destinations)?>'
            > </book-a-trip>
        </form>

        <section class="sec-2">
          <div class="itemhldr">
            <article class="dvider">
              <aside>
                  <img src="<?=base_url('frontend')?>/images/rocks.jpg">
              </aside>
              <article>
                  <div>
                    <p><?=$package->package_details->description?></p>
  
                    <h5>Package Inclusions</h5>
  
                    <ul class="pad-0 listn">
                      <li><p>Lorem ipsum dolor sit amet</p> </li>
                      <li><p>Consectetur adipiscing elit</p></li>
                      <li><p>Fusce ac nisl eros</p></li>
                      <li><p>Curabitur nunc orci, feugiat </p></li>
                      <li><p>Ac gravida id, feugiat et sem </p></li>
                      <li><p>In augue risus, viverra a ante vel</p></li>
                      <li><p>In augue risus, viverra a ante vel</p></li>
                    </ul>
                  </div>
              </article>
            </article>
            <div class="btm_sec">
                <ul class="pad-0 listn">
                  <li>
                    <h4>Php <?=number_format($package->rate)?>
                      <span>per person</span>
                    </h4>
                  </li>
                  <li>
                    <h5>Adults</h5>
                    <input type="number">
                    <span>Php 7,500</span>
                  </li>
                  <li>
                    <ul class="pad-0 listn">
                      <li>
                        <a href="">Add to Cart</a>
                      </li>
                      <li>
                        <a href="">Add to Checkout</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          
        </section>



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
    

        

      </div>