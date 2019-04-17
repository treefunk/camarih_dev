<footer>
        <div class="cs-container">
              <aside class="footer_logo" style="z-index:99">
                <a href="<?=base_url()?>" >
                    <img src="<?=base_url()?>frontend/images/logo.png" >
                </a>
              </aside>
              <ul class="pad-0 listn footer_list">
              
              <li>
                <h5><?=$footer_data['header']?></h5>
                <p><?=$footer_data['body']?></p>
              </li>
              <li>
                <h5>Contact Information</h5>
                <ul class="pad-0 listn">
                    <li> 
                      <p><i class="fa fa-map-marker" aria-hidden="true"></i><?=$footer_data['address']?></p> 
                    </li>
                    <li>
                      <p><i class="fa fa-mobile"></i><?=$footer_data['phone_1']?></p>
                    </li>
                    <li>
                      <p><i class="fa fa-mobile"></i><?=$footer_data['phone_2']?></p>
                    </li>
                    <li>
                      <p><i class="fa fa-envelope"></i><?=$footer_data['email']?></p>
                    </li>
                </ul>
              </li>
              <li>
                <a href="<?=$footer_data['facebook_link']?>"><img src="<?=base_url()?>frontend/images/footer-fb.png"></a>
                <a href="<?=$footer_data['messenger_link']?>"><img src="<?=base_url()?>frontend/images/footer-messenger.png"></a>
              </li>
              </ul>

        </div>

        <div class="btm-list">
          <ul class="pad-0 listn">
            <li><a href="">CAMARIH © <?=date('Y')?></a></li>
            <!-- <li><a href="">Privacy Policy</a></li>
            <li><a href="">Terms & Conditions</a></li> -->
          </ul>
        </div>

      </footer>
      
  </div>
</div>
  <!-- <script src="<?php //base_url()?>frontend/js/vendor/jquery-v3.2.1.min.js"></script> -->
  <script src="<?=base_url()?>frontend/js/vendor/bootstrap.min.js"></script>
  <script src="<?=base_url()?>frontend/js/owl.carousel.min.js"></script>
  <!-- toastr -->
  <script src="<?=base_url()?>flatlab/assets/toastr-master/toastr.js"></script>
  <script src="<?=base_url()?>frontend/js/main.js"></script>
  <script src="<?=base_url()?>frontend/js/jquery.magnific-popup.min.js"></script>
      <script src="<?=base_url()?>/assets/js/app.js"></script>
  <script type="text/javascript">

    
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
    

    
    $('.slct-pckge').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      responsive:{
          0:{
              items:1
          },
          601:{
              items:2
          },
          1000:{
              items:3
          }
      }

  });

  $('.cars').owlCarousel({
          loop:true,
          margin:10,
          nav:true,
          autoHeight:true,
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