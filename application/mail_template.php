<?php
// d($item_list);
    // $item_list , $total_price
?>

<ul class="main">
    <?php foreach($item_list as $item): ?>
        <?php if(isset($item[0]) && is_array($item[0])): // trip ?> 
            <?php if(count($item) == 1): // oneway trip ?>
                <ul>
                    <li>
                        <label for="trip_type">Trip Type</label>
                        <p>One-way Trip</p>
                    </li>
                    <li>
                        <label for="van_name">Van Name</label>
                        <p><?=$item[0]['van_name']?></p>
                    </li>
                    <li>
                        <label for="seats">Seats</label>
                        <p><?=$item[0]['seats']?></p>
                    </li>
                    <li>
                        <label for="destination">Destination</label>
                        <p><?=$item[0]['destination']?></p>
                    </li>
                    <li>
                        <label for="departure_date">Departure Date & Time:</label>
                        <p><?=$item[0]['departure_date']?></p>
                    </li>
                    <li>
                        <label for="pickup_location">Pickup Location</label>
                        <p><?=$item[0]['pickup_location']?></p>
                    </li>
                    <li>
                        <label for="drop_location">Drop Location</label>
                        <p><?=$item[0]['drop_location']?></p>
                    </li>
                    <li>
                        <label for="price">Price</label>
                        <p><?=$item[0]['price']?></p>
                    </li>
                    <li>
                        <label for="seat_num"># of seats</label>
                        <p><?=$item[0]['num_of_seats']?></p>
                    </li>
                </ul>
            <?php else: ?>
                <ul>
                    <li>
                        <label for="trip_type">Trip Type</label>
                        <p>Roundtrip</p>
                    </li>
                    <li>
                        <label for="van_name">Van Name</label>
                        <p>Departure: <?=$item[0]['van_name']?></p>
                        <p>Return: <?=$item[1]['van_name']?></p>
                    </li>
                    <li>
                        <label for="seats">Seats</label>
                        <p>Departure: <?=$item[0]['seats']?></p>
                        <p>Return: <?=$item[1]['seats']?></p>
                    </li>
                    <li>
                        <label for="destination">Destination</label>
                        <p>Departure: <?=$item[0]['destination']?></p>
                        <p>Return: <?=$item[1]['destination']?></p>
                    </li>
                    <li>
                        <label for="departure_date">Departure Date & Time:</label>
                        <p>Departure: <?=$item[0]['departure_date']?></p>
                        <p>Return: <?=$item[1]['departure_date']?></p>
                    </li>
                    <li>
                        <label for="pickup_location">Pickup Location</label>
                        <p>Departure: <?=$item[0]['pickup_location']?></p>
                        <p>Return: <?=$item[1]['pickup_location']?></p>
                    </li>
                    <li>
                        <label for="drop_location">Drop Location</label>
                        <p>Departure: <?=$item[0]['drop_location']?></p>
                        <p>Return: <?=$item[1]['drop_location']?></p>
                    </li>
                    <li>
                        <label for="price">Price</label>
                        <p>Departure: <?=$item[0]['price']?></p>
                        <p>Return: <?=$item[1]['price']?></p>
                    </li>
                    <li>
                        <label for="seat_num"># of seats</label>
                        <p>Departure: <?=$item[0]['price']?></p>
                        <p>Return: <?=$item[1]['price']?></p>
                    </li>
                </ul>
            <?php endif; ?>
        <?php elseif($item['type'] == 'van'): //van rent ?>
            <ul>
                <li>
                    <label for="van_name">Van</label>
                    <p><?=$item['van_name']?></p>
                </li>
                <li>
                    <label for="departure">Departure date</label>
                    <p><?=$item['departure_date']?></p>
                </li>
                <li>
                    <label for="destination">Destination</label>
                    <p><?=$item['destination']?></p>
                </li>
                <li>
                    <label for="trip_type">Trip Type</label>
                    <p><?=$item['trip_type']?></p>
                </li>
                <li>
                    <label for="price">Price</label>
                    <p><?=$item['price']?></p>
                </li>
            </ul>
        <?php elseif($item['type'] == 'package'): // package ?>
            <ul>
                <li>
                    <label for="package_name">Package Name</label>
                    <p><?=$item['package_name']?></p>
                </li>
                <li>
                    <label for="adult_count">Adult Count</label>
                    <p><?=$item['adult_count']?></p>
                </li>
                <li>
                    <label for="price">Price</label>
                    <p><?=$item['price']?></p>
                </li>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<div class="total-price">
    <p>
        Total: PHP <?=$total_price?>
    </p>
</div>
