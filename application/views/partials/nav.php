<body>
  <div class="homepage" id="app">
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
                            <a href="#" class="navbar-brand"><img src="<?=base_url()?>frontend/images/logo.png"></a>
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
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our Vans</a></li>
                            <li><a href="#">Trip schedule</a></li>
                            <li><a href="#">Tour packages</a></li>
                            <li class="bg-orange"><a href="#">Contact Us</a></li>
                            <li class="acc dropdown">
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#">My Account<b class="caret"></b></a>
                              <ul role="menu" class="dropdown-menu">
                                  <li><a href="#">Inbox</a></li>
                                  <li><a href="#">Drafts</a></li>
                                  <li><a href="#">Sent Items</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#">Trash</a></li>
                              </ul>
                            </li>
                        </ul>

                        
                    </div>
                  </div>
                  
              </nav>

              <ul class="listn pad-0 top-list">
                  <li>
                    <p>My Account</p>
                    <a href="">
                      <i class="fa fa-shopping-cart" aria-hidden="true">
                        <div class="qntity">
                          <span>1</span>
                        </div>
                      </i>
                    </a>
                  </li>
                  <li>
                                            <!-- <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                        </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                                             -->
                  </li>
              </ul>
          </div>
      </header>