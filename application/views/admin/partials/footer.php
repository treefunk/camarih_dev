<footer class="site-footer">
          <div class="text-center">
              <?=date('Y')?> &copy; Camarih Transport
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <!-- <script src="<?php //echo base_url('flatlab')?>/js/jquery.js"></script> -->
    <script src="<?=base_url('flatlab')?>/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?=base_url('flatlab')?>/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.scrollTo.min.js"></script>
    <script src="<?=base_url('flatlab')?>/js/slidebars.min.js"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?=base_url('flatlab')?>/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="<?=base_url('flatlab')?>/js/common-scripts.js"></script>
    
    
    <script src="<?=base_url()?>/assets/js/app.js"></script>

    <script>

    $(function(){
          $('#default').stepy({
              backLabel: 'Previous',
              block: true,
              nextLabel: 'Next',
              titleClick: true,
              titleTarget: '.stepy-tab'
          });



          $(".fancybox").fancybox();


  
    })


    </script>



  </body>
</html>