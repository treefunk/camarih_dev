<section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <i class="fa fa-bars"></i>
          </div>
          <!--logo start-->
          <a href="<?=base_url('admin')?>" class="logo" >Cama<span>rih</span></a>
          <!--logo end-->
          <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">
              <!-- settings start -->
              <li class="dropdown">
 
              <!-- notification dropdown end -->
          </ul>
          </div>
          <div class="top-nav ">
              <ul class="nav pull-right top-menu">
                  <!-- <li>
                      <input type="text" class="form-control search" placeholder="Search">
                  </li> -->
                  <!-- user login dropdown start-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="img/avatar1_small.jpg">
                          <span class="username"><strong><?=$admin->username?></strong></span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li><a href="<?=base_url('admin/logout')?>"><i class="fa fa-key"></i> Log Out</a></li>
                      </ul>
                  </li>
                  <!-- user login dropdown end -->
                  <!-- <li class="sb-toggle-right">
                      <i class="fa  fa-align-right"></i>
                  </li> -->
              </ul>
          </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <!-- <li>
                      <a href="<?php //base_url('admin')?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li> -->

                  <li class="sub-menu">
                      <a href="<?=base_url('admin')?>" class="<?=isActive('admin')?>">
                          <i class="fa fa-laptop"></i>
                          <span>Admin Management</span>
                      </a>
                      <!-- <ul class="sub">
                          <li><a  href="boxed_page.html">Boxed Page</a></li>
                          <li><a  href="horizontal_menu.html">Horizontal Menu</a></li>
                          <li><a  href="header-color.html">Different Color Top bar</a></li>
                          <li><a  href="mega_menu.html">Mega Menu</a></li>
                          <li><a  href="language_switch_bar.html">Language Switch Bar</a></li>
                          <li><a  href="email_template.html" target="_blank">Email Template</a></li>
                      </ul> -->
                  </li>

                  <?php $cms_sub_items = ['about','sliders','testimonials']; $cms = isActive($cms_sub_items); ?>
                  <li class="sub-menu dcjq-parent-li">
                      <a href="javascript:;" class="dcjq-parent <?=$cms[0]?>">
                          <span>CMS</span> 
                      <span class="dcjq-icon"></span></a>
                      <ul class="sub" style="<?=$cms[1]?>">
                          <li class="<?=isActive('about')?>"><a href="<?=base_url('about/edit')?>" >About</a></li>
                          <li class="<?=isActive('sliders')?>"><a href="<?=base_url('sliders')?>" >Sliders</a></li>
                          <li class="<?=isActive('testimonials')?>"><a href="<?=base_url('testimonials')?>" >Testimonials</a></li>
                      </ul>
                    </li>

                    <li class="sub-menu">
                      <a href="<?=base_url('tourpackages')?>" class="<?=isActive("tourpackages")?>">
                          <i class="fa fa-truck"></i>
                          <span>Tour Packages</span>
                      </a>
                    </li>

                    <li class="sub-menu">
                        <a href="<?=base_url('trip_availability')?>" class="<?=isActive("trip_availability")?>">
                            <i class="fa fa-road"></i>
                            <span>Trip Availability</span>
                        </a>
                    </li>

                  <li class="sub-menu">
                      <a href="<?=base_url('destinations')?>" class="<?=isActive("destinations")?>">
                          <i class="fa fa-building-o"></i>
                          <span>Destinations</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="<?=base_url('vans')?>" class="<?=isActive("vans")?>">
                          <i class="fa fa-truck"></i>
                          <span>Vans</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="<?=base_url('tripschedule')?>" class="<?=isActive("tripschedule")?>">
                            <i class="fa fa-truck"></i>
                          <span>Schedule</span>
                      </a>
                  </li>

                
                  <!--multi level menu end-->

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->