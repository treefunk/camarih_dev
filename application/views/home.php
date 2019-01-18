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


<form action="<?=base_url()?>availability/check" method="POST">
<article class="book-trip">
  <div>
    <ul class="pad-0 listn">
      <li>
        <p>Round-trip</p>
      </li>
      <li>
        <p>One-way</p>
      </li>
    </ul>
  </div>
  <ul class="pad-0 listn">
    <li>
      <div>
        <h4>Book A trip</h4>
      </div>
    </li>
    <li>
      <div>
        <ul class="pad-0 listn">
          <li>
            <h5>From</h5>
            <select name="destination_from">
              <option value="">Select a Location</option>
              <?php foreach($destinations as $destination): ?>
                <option value="<?=$destination->id?>"><?=$destination->name?></option>
              <?php endforeach; ?>
            </select>
            <input name="departure_from" type="date">
          </li>
          <li>
            <h5>To</h5>
            <select name="destination_to">
              <option value="">Select a Location</option>
              <?php foreach($destinations as $destination): ?>
                <option value="<?=$destination->id?>"><?=$destination->name?></option>
              <?php endforeach; ?>
            </select>
            <input name="departure_to" type="date">
          </li>
        </ul>
      </div>
    </li>
    <li>
      <div>
        <button type="submit" style="background-color:transparent">
          <h5>Check <i class="fa fa-arrow-right"></i> Availability</h5>

        </button>
      </div>
    </li>
  </ul>
</form>
</article>

<section class="sec-2">
    <article class="pckage_wrap clearfix">
      <aside>
        <img src="<?=base_url()?>frontend/images/package.jpg">
      </aside>

      <article>
        <h4>Tour Package</h4>

        <div>
          <ul class="pad-0 listn">
              <li>
                <h3>3D2N El Nido</h3>
              </li>
              <li>
                <h5>Hotel + Tours + transfers</h5>
              </li>
              <li>
                <h4>Php 2,790 <span>per person</span></h4>
              </li>
              <li>
                <h6>Adults</h6>
                <input type="number">
              </li>
          </ul>
          <aside>
            <ul class="pad-0 listn">
              <li>
                <a href="">View Details</a>
              </li>
              <li>
                <a href="">Add to cart</a>
              </li>
            </ul>
          </aside>

        </div>

      </article>

      <div class="view_all">
        <a href="">View All Packages</a>
      </div>
    </article>
</section>

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



</div>