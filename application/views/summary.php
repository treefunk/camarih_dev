<div class="check">
    <section class="sec-1">
        <div class="overlay"></div>
    </section>

<section class="sec-2">
    <final-summary
    :selected_data='<?=json_encode($selected)?>'
    :selected_seats_data='<?=json_encode($selected_seats)?>'
    :selected_package_data='<?=json_encode($selected_package)?>'
    :final_price='<?=json_encode($final_price)?>'
    >
    </final-summary>

    <form action="<?=base_url('availability/add_to_cart')?>" method="post">
        <button class="btn btn_green" type="submit">Add To Cart</button>
    </form>
</section>
</div>
