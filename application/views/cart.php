<div class="cart">

<section class="sec-1">
  <article class="hero">
      <h3>My Cart</h3>
  </article>
  <div class="overlay"></div>

</section>
            <shopping-cart
            :shopping_cart_data='<?=json_encode($cart)?>'
            item_remove_url='<?=base_url('cart/removeitem/')?>'
            checkout_url='<?=base_url('checkout')?>'
            edit_base_url='<?=base_url('availability/book_departure')?>'
            :item_conflicts='<?=json_encode($conflicts)?>'
            >
            </shopping-cart>

        </div>
        <!-- <a href="<?php //base_url('availability/process_cart')?>">
        <button class="btn">Checkout</button>
        </a> -->
</section>
</div>
