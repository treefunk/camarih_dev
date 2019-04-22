<?php
// d($item_list);
    // $item_list , $total_price
?>

<div class="booking-part">


<ul>
    <?php foreach($item_list as $item): ?>
        <?php if(isset($item[0]) && is_array($item[0])): // trip ?> 
            <?php if(count($item) == 1): // oneway trip ?>
                <li class="booking-card">
                    <div>
                        <div class="body">
                            <ul class="pad-0 listn">
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Trip Type:</p>
                                        </div>
                                        <div class="children">
                                            <p>One-way</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Van: </p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['van_name']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Seats:</p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['seats']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Destination/Return Location:</p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['destination']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Departure Date &amp; Time:</p>
                                        </div>
                                        <div class="children">
                                            <p><?=$item[0]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Pickup Location: </p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['pickup_location']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Drop Location: </p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['drop_location']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Price: </p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['price']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p># of Seats:</p>
                                        </div>
                                        <div class="children">
                                            <!---->
                                            <p><?=$item[0]['num_of_seats']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    
                    </div>
                </li>
            <?php else: ?>
                <li class="booking-card"> 
                    <div>
                        <div class="body">
                            <ul class="pad-0 listn">
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Trip Type:</p>
                                        </div>
                                        <div class="children">
                                            <p>Round-trip</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Van: </p>
                                        </div>
                                        <div class="children"><span>Departure:</span>
                                            <p><?=$item[0]['van_name']?></p>
                                            <div>
                                                Return:
                                                <p><?=$item[1]['van_name']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Seats:</p>
                                        </div>
                                        <div class="children"><span>Departure:</span>
                                            <p><?=$item[0]['seats']?></p>
                                            <div>
                                                Return:
                                                <p class="return"><?=$item[1]['seats']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Destination/Return Location:</p>
                                        </div>
                                        <div class="children"><span>Departure:</span>
                                            <p><?=$item[0]['destination']?></p>
                                            <div>
                                                Return:
                                                <p>Return: <?=$item[1]['destination']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Departure Date &amp; Time:</p>
                                        </div>
                                        <div class="children">
                                            <p><?=$item[0]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Return Date &amp; Time:</p>
                                        </div>
                                        <div class="children">
                                            <p><?=$item[1]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Pickup Location: </p>
                                        </div>
                                        <div class="children"><span>
                                                Departure:
                                            </span>
                                            <p><?=$item[0]['pickup_location']?></p>
                                            <div>
                                                Return:
                                                <p><?=$item[1]['pickup_location']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Drop Location: </p>
                                        </div>
                                        <div class="children"><span>
                                                Departure:
                                            </span>
                                            <p><?=$item[0]['drop_location']?></p>
                                            <div>
                                                Return:
                                                <p><?=$item[1]['drop_location']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p>Price: </p>
                                        </div>
                                        <div class="children"><span>
                                                Departure:
                                            </span>
                                            <p>Departure: <?=$item[0]['price']?></p>
                                            <div>
                                                Return:
                                                <p>Return: <?=$item[1]['price']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="parent">
                                        <div class="children">
                                            <p># of Seats:</p>
                                        </div>
                                        <div class="children"><span>
                                                Departure:
                                            </span>
                                            <p><?=$item[0]['price']?></p>
                                            <div>
                                                Return:
                                                <p><?=$item[1]['price']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    
                </li>
            <?php endif; ?>
        <?php elseif($item['type'] == 'van'): //van rent ?>
            <li class="booking-card">
                <div>
                    <div class="body">
                        <ul class="pad-0 listn">
                            <li>     
                                <div class="parent">
                                    <div class="children">
                                        <p>Van Type</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['van_name']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Departure Date</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['departure_date']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Destination:</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['destination']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Trip type:</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['trip_type']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Total</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['price']?></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        <?php elseif($item['type'] == 'package'): // package ?>
            <li class="booking-card">
                <div>
                    <div class="body">
                        <ul class="pad-0 listn">
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Package Name</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['package_name']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Adult Count</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['adult_count']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div  class="parent">
                                    <div  class="children">
                                        <p >Rate</p>
                                    </div>
                                    <div  class="children">
                                        <p ><?=$item['rate']?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="parent">
                                    <div class="children">
                                        <p>Total</p>
                                    </div>
                                    <div class="children">
                                        <p><?=$item['price']?></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<div class="total-price">
    <p>
        Total: PHP <?=$total_price?>
    </p>
</div>
</div>