<div class="packages">

        <section class="sec-1">
          <article class="hero">
              <h3>Tour Packages</h3>
          </article>
          <div class="overlay"></div>

        </section>


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
                    <select>
                      <option>Select a Location</option>
                    </select>
                    <input type="date">
                  </li>
                  <li>
                    <h5>To</h5>
                    <select>
                      <option>Select a Location</option>
                    </select>
                    <input type="date">
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <div>
                <h5>Check <i class="fa fa-arrow-right"></i> Availability</h5>
              </div>
            </li>
          </ul>
        </article>

        
        <?php $index = 1; foreach($packages as $package): $left = !(($index % 2) == 0); ?>
        
        <section class="<?=$left ? 'sec-2' : 'sec-3 clearfix' ?>">
            <article class="pckage_wrap clearfix">

              <div class="clearfix">
                <aside class="<?=$left ? 'right' : 'left' ?>">
                  <img src="<?=base_url('frontend/images/')?>package.jpg">
                </aside>

                <article class="<?=$left ? 'left' : 'right' ?>">
                <div>
                  <ul class="pad-0 listn">
                      <li>
                        <h3><?=$package->name?></h3>
                      </li>
                      <li>
                        <h5><?=$package->package_details->description?></h5>
                      </li>
                      <li>
                        <h4>Php <?=$package->rate?> <span>per person</span></h4>
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
        </section>


        <?php $index++; endforeach; ?>



        <section class="sec-3 clearfix">
            <article class="pckage_wrap clearfix">

              <div class="clearfix">
                <aside class="left">
                  <img src="<?=base_url('frontend/images/')?>package.jpg">
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

            </section>

            pack list
            <package-list :packages='<?=json_encode($packages)?>'></package-list>

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