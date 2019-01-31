<div class="check">
    <section class="sec-1">
        <div class="overlay"></div>
    </section>

<section class="sec-2">
    <h1>Cart list (TBD)</h1>
    <div>
            
            <shopping-cart
            :shopping_cart_data='<?=json_encode($cart)?>'
            item_remove_url='<?=base_url('cart/removeitem/')?>'
            >
            </shopping-cart>

        </div>
</section>
</div>
