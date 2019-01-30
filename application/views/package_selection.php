<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <!-- <book-summary
        :current_seats_length='<?php //json_encode(count($this->session->userdata('selected_seats')))?>'
        :book_data='<?php //json_encode($this->session->userdata('selected'))?>'
    >
    </book-summary> -->
    <h2>Choose a package:</h2>
        <form action="<?=base_url('availability/summary')?>" method="POST">
            <package-selection
            :packages_data='<?=json_encode($packages)?>'>
            </package-selection>
        </form>
        <!-- //TODO back button -->
        <!-- <a href="<?php //base_url("availability/book/{$this->session->userdata('selected')['rate_id']}")?>">
            <button class="btn">Back</button>
        </a>     -->
</section>

