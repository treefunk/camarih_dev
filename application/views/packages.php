<div class="packages">

        <section class="sec-1">
          <article class="hero">
              <h3>Tour Packages</h3>
          </article>
          <div class="overlay"></div>

        </section>

        <book-a-trip
        url='<?=base_url('availability/check')?>'
        :destinations_data='<?=json_encode($destinations)?>'
        :origins_data='<?=json_encode($origins)?>'
        > </book-a-trip>


            <package-list 
            :packages='<?=json_encode($packages)?>'
            single_url="<?=base_url('packages/selected')?>"
            add_to_cart_url="<?=base_url('packages/add_to_cart')?>"
            main_image_url="<?=base_url($this->packageimage_model->upload_path)?>"
            default_image_url="<?=$default_image?>"
            >
          </package-list>
          <div class="text-center">
            <ul class="pagination">
              <?=$links?>
            </ul>

          </div>

      </div>