<div class="packages">

  <section class="sec-1">
    <article class="hero">
      <h3><?=$page_title?></h3>
    </article>
    <div class="overlay"></div>

  </section>

  <book-a-trip
  url='<?=base_url('availability/check')?>'
  :destinations_data='<?=json_encode($destinations)?>'
  :origins_data='<?=json_encode($origins)?>'
  > </book-a-trip>

  <div class="pagewrapper3">
   <!-- Content for Day Tours Listing -->
    <article class="overview">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dictum tellus leo. Maecenas semper non dolor imperdiet feugiat. Morbi a enim urna. Nullam tincidunt porta justo non eleifend. </p>
    </article>
    
   <!-- Filter Day Tours -->
    <?php if (!$_GET): ?>
      <?php $_GET = array('location' => '', 'duration' => '', 'pax' => '', 'price_range' => '' ); ?>
    <?php endif ?>
   <form method="get">
     <filter-tours 
     service_name="<?=$page_title?>" 
     :destinations_data='<?=json_encode($destinations)?>'
     is_day_tour='<?=json_encode($is_day_tour)?>'
     :durations_data = '<?=json_encode(@$durations)?>'
     :selected_data = '<?=json_encode($_GET)?>'
     >  
     </filter-tours>
   </form>

   <!-- List of Day Tours -->
   <section class="day-tours">
      <package-list 
       :packages='<?=json_encode($packages)?>'
       single_url="<?=base_url('packages/selected')?>"
       add_to_cart_url="<?=base_url('packages/add_to_cart')?>"
       main_image_url="<?=base_url($this->packageimage_model->upload_path)?>"
       default_image_url="<?=$default_image?>"
       >
      </package-list>
   </section>
   <!-- Pagination -->
    <div class="pagination">
      <?php if ($links): ?>
         <ul class="pages">
           <li>Pages:</li>
           <?=$links?>
         </ul>
         <aside class="page-count">PAGE <?=$current_page?> of <?=$total_pages?></aside>
      <?php else: ?>
          <ul class="pages">
           <li>Pages:</li>
           <li><a href="#" class="active">1</a></li>
          </ul>
          <aside class="page-count">PAGE 1 of 1</aside>
      <?php endif ?>
    </div>
  </div>
</div>