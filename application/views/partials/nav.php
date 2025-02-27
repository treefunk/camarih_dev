<body>
  <div class="homepage app">
      <header id="header">
        
          <div class="navbar-holder">
              <!-- if you want to customize the nav, just add class and call it on css -->
              <nav role="navigation" class="navbar navbar-default nav-custom">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="cs-container">
                    <div class="navbar-header">
                        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="nav-log">
                            <a href="<?=base_url()?>" class="navbar-brand"><img src="<?=base_url()?>frontend/images/logo.png"></a>
                        </div>
                      
                    </div>
                    <!-- Collection of nav links, forms, and other content for toggling -->
                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <!-- <ul class="nav navbar-nav">
                          <li class="active"><a href="#">Home</a></li>
                          <li><a href="#">Profile</a></li>
                          <li class="dropdown">
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Messages <b class="caret"></b></a>
                              <ul role="menu" class="dropdown-menu">
                                  <li><a href="#">Inbox</a></li>
                                  <li><a href="#">Drafts</a></li>
                                  <li><a href="#">Sent Items</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#">Trash</a></li>
                              </ul>
                          </li>
                        </ul> -->
                      
                        <ul class="nav navbar-nav navbar-right">
                            <li class="<?=isPageActive("")?>"><a href="<?=base_url()?>">Home</a></li>
                            <li class="<?=isPageActive("aboutus")?>"><a href="<?=base_url('aboutus')?>">About Us</a></li>
                            <li class="<?=isPageActive("rates")?>"><a href="<?=base_url('rates')?>">Rates</a></li>
                            <li class="<?=isPageActive("ourvans")?>"><a href="<?=base_url('ourvans')?>">Our Vans</a></li>
                            <li class="<?=isPageActive("schedule")?>"><a href="<?=base_url('schedule')?>">Trip schedule</a></li>
                            <li class="<?=isPageActive("packages")?> dropdown-">
                              <a>Tour packages</a>
                              <ul class="pad-0 listn submenu-">
                                <li>
                                  <a href="<?=base_url('packages/package_tours')?>">Package Tours</a>
                                </li>
                                <li>
                                  <a href="<?=base_url('packages/day_tours')?>">Day Tours</a>
                                </li>
                              </ul>
                            </li>
                            <li class="bg-orange"><a class="<?=isPageActive("contact")?>" href="<?=base_url('contact')?>">Contact Us</a></li>
                            <!-- <li class="acc dropdown">
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#">My Account<b class="caret"></b></a>
                              <ul role="menu" class="dropdown-menu">
                                  <li><a href="#">Inbox</a></li>
                                  <li><a href="#">Drafts</a></li>
                                  <li><a href="#">Sent Items</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#">Trash</a></li>
                              </ul>
                            </li> -->
                        </ul>

                        
                    </div>
                  </div>
                  
              </nav>

              <ul class="listn pad-0 top-list">
                  <li>
                    <p>  </p>
                    <a href="<?=base_url('cart')?>">
                        <cart-icon
                        :shopping_cart_data = '<?=json_encode($this->session->userdata('cart'))?>'
                        :shopping_cart_num_data = '<?=count($this->session->userdata('cart'))?>'
                        >
                        </cart-icon>
                      
                    </a>
                  </li>
                  <li>
                  </li>

              </ul>
          </div>
      </header>