<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <book-summary
        :current_seats_length='<?=json_encode(count($this->session->userdata('selected_seats')))?>'
        :book_data='<?=json_encode($this->session->userdata('selected'))?>'
    >
    </book-summary>
    <h2>Choose a package:</h2>
        <form action="<?=base_url('availability/summary')?>" method="POST">
            <package-selection
            :packages_data='<?=json_encode($packages)?>'>
            </package-selection>
        </form>
        <a href="<?=base_url("availability/book/{$this->session->userdata('selected')['rate_id']}")?>">
            <button class="btn">Back</button>
        </a>    
</section>

