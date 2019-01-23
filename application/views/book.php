<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <ul class="parent pad-0 listn">
        <book-summary
        :book_data='<?=json_encode($selected)?>'
        >

        </book-summary>
        <li>
         
            <div class="van-hldr">
                <form action="<?=base_url('availability/packages')?>" method="POST">
                <seat-plan-selection
                :seats_data='<?=json_encode($seat_map)?>'
                :occupied_seats_data='<?=json_encode($occupied_seat_map)?>'
                :pending_seats_data='<?=json_encode($pending_seat_map)?>'
                :current_seats_data='<?=json_encode($current_seat_map)?>'
                ></seat-plan-selection>
                
                </form>
            </div>
        </li>
        <li></li>
        <a href="<?=base_url('availability/check')?>">
            <button class="btn">Back</button>
        </a>    
                
    </ul>
    
    </div>
</section>

