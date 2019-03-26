<div class="packages">

        <section class="sec-1">
          <article class="hero">
              <h3>Tour Packages</h3>
          </article>
          <div class="overlay"></div>

        </section>

        <book-a-trip
        :destinations='<?=json_encode($destinations)?>'
        >

        </book-a-trip>

            <package-list 
            :packages='<?=json_encode($packages)?>'
            single_url="<?=base_url('packages/selected')?>"
            add_to_cart_url="<?=base_url('packages/add_to_cart')?>"
            main_image_url="<?=base_url($this->packageimage_model->upload_path)?>"
            >
          </package-list>

            <!-- TO add another package uncomment code below -->

<!--
            <article class="pckage_wrap clearfix">

              <div class="clearfix">
                <aside class="left">
                  <img src="<?php //base_url('frontend/images/')?>package.jpg">
                </aside>

                <article class="right">
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
              </div>

            </article>
-->
            



        

        

      </div>