<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <ul class="parent pad-0 listn">
        <li>
            <div class="item">
                <div>
                    <label for="destination_from">Origin:</label>
                    <p><?=$selected['origin']->name?></p>
                </div>
                <div>
                    <label for="departure_to">Destination:</label>
                    <p><?=$selected['destination']->name?></p>
                </div>
                <div>
                    <label for="departure_from">From:</label>
                    <p><?=$selected['from']?></p>
                </div>
                <div>
                    <label for="departure_to">To:</label>
                    <p><?=$selected['to']?></p>
                </div>
                <div>
                    <p>Price: <?=$selected['rate_price']?></p>
                </div>
            </div>
        </li>
        <li>
            <div class="app van-hldr">
                <form action="<?=base_url('availability/process_booking')?>" method="POST">
                <seat-plan-selection
                :seats_data='<?=json_encode($seat_map)?>'
                :occupied_seats_data='<?=json_encode($occupied_seat_map)?>'
                ></seat-plan-selection>
                
                </form>
            </div>
        </li>
        <li></li>
                
    </ul>
    
    </div>
</section>

