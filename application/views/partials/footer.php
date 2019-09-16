<footer style="width: 100%; float: left">
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
            <li><a href="">Privacy Policy</a></li>
              <li><a href="">Terms & Conditions</a></li>
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
    <!-- <script type="text/javascript" src="<?=base_url()?>frontend/js/jquery-1.11.0.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=base_url()?>frontend/js/jquery-migrate-1.2.1.min.js"></script> -->
    <script type="text/javascript" src="<?=base_url()?>frontend/js/slick.min.js"></script>
    <script src="<?=base_url()?>frontend/js/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>/assets/js/app.js"></script>
    <script type="text/javascript">
      $('.highlights').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          centerPadding: '5px',
          arrows: true,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 560,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
      // jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"></div><div class="quantity-button quantity-down"></div></div>').insertAfter('.quantity input');
      jQuery('.quantity').each(function() {
        var spinner = jQuery(this),
          input = spinner.find('input[type="number"]'),
          btnUp = spinner.find('.quantity-up'),
          btnDown = spinner.find('.quantity-down'),
          min = input.attr('min'),
          max = input.attr('max');

        btnUp.click(function() {
          var oldValue = parseFloat(input.val());
          if (oldValue >= max) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue + 1;
          }
          spinner.find("input").val(newVal);
          spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
          var oldValue = parseFloat(input.val());
          if (oldValue <= min) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue - 1;
          }
          spinner.find("input").val(newVal);
          spinner.find("input").trigger("change");
        });

      });
      $(document).ready(function() {
          $('.gallery-item').magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery:{
              enabled:true,
              
            }
          });
        });

      var footerX = $('footer').offset().top;
      
      $(window).on('scroll', function(){
        
        var scrolled = $(window).scrollTop() + ($(window).height() - 50);

        if(scrolled > 10){
          $('.addtocart').fadeIn();
        }

        if (scrolled > footerX){
          $('.addtocart').css("position", "relative");
        }
        else {
          $('.addtocart').css("position", "fixed");
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