<section id="container" class="">
      <!--header start-->
      <header class="header dark-bg">
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
                          <i class="fa fa-group"></i>
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

                  <?php $cms_sub_items = ['about','sliders','testimonials','footer_details']; $cms = isActive($cms_sub_items); ?>
                  <?php if (uri_string() == "tourpackages/cms"): ?>
                    <?php $cms[0] = "active" ?>
                  <?php endif ?>
                  <li class="sub-menu dcjq-parent-li">
                      <a href="javascript:;" class="dcjq-parent <?=$cms[0]?>">
                          <span>CMS</span> 
                      <span class="dcjq-icon"></span></a>
                      <ul class="sub" style="<?=$cms[1]?>">
                          <li class="<?=isActive('about')?>"><a href="<?=base_url('about/edit')?>" >About</a></li>
                          <li class="<?php echo (uri_string() == "tourpackages/cms") ? 'active' : ''; ?>"><a href="<?=base_url('tourpackages/cms')?>" >Tours Description</a></li>
                          <li class="<?=isActive('sliders')?>"><a href="<?=base_url('sliders')?>" >Sliders</a></li>
                          <li class="<?=isActive('testimonials')?>"><a href="<?=base_url('testimonials')?>" >Testimonials</a></li>
                          <li class="<?=isActive('footer_details')?>"><a href="<?=base_url('footer_details')?>" >Footer Details</a></li>
                      </ul>
                    </li>

                <?php $reservation_sub_items = ['booking-reservations','van-reservations','package-reservations']; $reservation = isActive($reservation_sub_items); ?>
                  <li class="sub-menu dcjq-parent-li">
                      <a href="javascript:;" class="dcjq-parent <?=$reservation[0]?>">
                          <span>Reservations</span> 
                      <span class="dcjq-icon"></span></a>
                      <ul class="sub" style="<?=$reservation[1]?>">
                          <li class="<?=isActive('booking-reservations')?>"><a href="<?=base_url('booking-reservations')?>">Booking</a></li>
                          <li class="<?=isActive('van-reservations')?>"><a href="<?=base_url('van-reservations')?>" >Van Hire</a></li>
                          <li class="<?=isActive('package-reservations')?>"><a href="<?=base_url('package-reservations')?>" >Package</a></li>
                      </ul>
                    </li>
                    <li class="sub-menu">
                      <a href="<?=base_url('inquiries')?>" class="<?php echo (uri_string() == "inquiries" || strpos(uri_string(), "inquiries") !== FALSE)  ? 'active' : ''; ?>">
                          <i class="fa fa-archive"></i>
                          <span>Tour Inquiries</span>
                      </a>
                    </li>
                    <li class="sub-menu">
                      <a href="<?=base_url('tourpackages')?>" class="<?php echo (uri_string() == "tourpackages") ? 'active' : ''; ?>">
                          <i class="fa fa-archive"></i>
                          <span>Tour Packages</span>
                      </a>
                    </li>
                    <li class="sub-menu">
                      <a href="<?=base_url('tourpackages/organize')?>" class="<?php echo (strpos(uri_string(), 'tourpackages/organize')  !== false) ? 'active' : ''; ?>">
                          <i class="fa fa-archive"></i>
                          <span>Packages Naming</span>
                      </a>
                    </li>

                    <li class="sub-menu">
                        <a href="<?=base_url('trip_availability')?>" class="<?=isActive("trip_availability")?>">
                            <i class="fa fa-road"></i>
                            <span>Trip Availability</span>
                        </a>
                    </li>

                  <!-- <li class="sub-menu">
                      <a href="<?php // base_url('destinations')?>" class="<?php //isActive("destinations")?>">
                          <i class="fa fa-building-o"></i>
                          <span>Destinations</span>
                      </a>
                  </li> -->

                  <li class="sub-menu">
                      <a href="<?=base_url('vans')?>" class="<?=isActive("vans")?>">
                          <i class="fa fa-truck"></i>
                          <span>Vans</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="<?=base_url('tripschedule')?>" class="<?=isActive("tripschedule")?>">
                            <i class="fa fa-calendar"></i>
                          <span>Schedule</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="<?=base_url('contactus')?>" class="<?=isActive("contactus")?>">
                            <i class="fa fa-envelope-o"></i>
                          <span>Contact Details</span>
                      </a>
                  </li>

                
                  <!--multi level menu end-->

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->