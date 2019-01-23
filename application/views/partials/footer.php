<footer>
        <div class="cs-container">
              <aside class="footer_logo">
                <img src="<?=base_url()?>frontend/images/logo.png">
              </aside>
              <ul class="pad-0 listn footer_list">
              
              <li>
                <h5>About Camarih Palawan Shuttle Transport Services</h5>
                <p>CAMARIH Transport is the best in providing convenient and safe yet affordable transportation for locals and tourists who are drawn to explore the beauty of Northern Palawan.</p>
              </li>
              <li>
                <h5>Contact Information</h5>
                <ul class="pad-0 listn">
                    <li> 
                      <p><i class="fa fa-map-marker" aria-hidden="true"></i> Mitra Rd Puerto Princesa City, Puerto Princesa, Philippines</p> 
                    </li>
                    <li>
                      <p><i class="fa fa-mobile"></i>+63 917 849 7646</p>
                    </li>
                    <li>
                      <p><i class="fa fa-mobile"></i>+63 939 933 7002</p>
                    </li>
                    <li>
                      <p><i class="fa fa-envelope"></i> camarihtransport@gmail.com</p>
                    </li>
                </ul>
              </li>
              <li>
                <a href=""><img src="<?=base_url()?>frontend/images/footer-fb.png"></a>
                <a href=""><img src="<?=base_url()?>frontend/images/footer-messenger.png"></a>
              </li>
              </ul>

        </div>

        <div class="btm-list">
          <ul class="pad-0 listn">
            <li><a href="">CAMARIH © 2017</a></li>
            <li><a href="">Privacy Policy</a></li>
            <li><a href="">Terms & Conditions</a></li>
          </ul>
        </div>

      </footer>
      
  </div>
</div>
  <script src="<?=base_url()?>frontend/js/vendor/jquery-v3.2.1.min.js"></script>
  <script src="<?=base_url()?>frontend/js/vendor/bootstrap.min.js"></script>
  <script src="<?=base_url()?>frontend/js/owl.carousel.min.js"></script>
  <script src="<?=base_url()?>frontend/js/main.js"></script>

      <script src="<?=base_url()?>/assets/js/app.js"></script>
  <script type="text/javascript">
    $('.home-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
    });

    
    $('.testi-carou').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      dots: true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
    });

  </script>
</body>

</html>