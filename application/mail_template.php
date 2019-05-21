<?php
// d($item_list);
    // $item_list , $total_price
?>

<div class="booking-part" style=" max-width: 800px; border: 1px solid #515151; margin: 0 auto;">

<div class="total-price" style=" padding: 10px 0px; background: #515151;">
    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
            <div class="children" style="width: 100%; padding: 0px 20px;">
                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px; color: #fff;">Booking Details:</p>
            </div>
    </div>
</div>

<ul class="pad-0 listn" style="padding: 0px; list-style-type: none;">
    <?php foreach($item_list as $item): ?>
        <?php if(isset($item[0]) && is_array($item[0])): // trip ?> 
            <?php if(count($item) == 1): // oneway trip ?>
                <li class="booking-card">
                    <div>
                        <div class="body" style="padding: 15px 0px 0px;">
                            <ul class="pad-0 listn" style="padding: 0px; list-style-type: none;">
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Trip Type:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">One-way</p>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Van: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['van_name']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Seats:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['seats']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Destination/Return Location:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['destination']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Departure Date &amp; Time:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Pickup Location: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['pickup_location']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Drop Location: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['drop_location']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Price: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['price']?></p>
                                            <!---->
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"># of Seats:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <!---->
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['num_of_seats']?></p>
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
                        <div class="body" style="padding: 15px 0px 0px;">
                            <ul class="pad-0 listn" style="padding: 0px; list-style-type: none;">
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Trip Type:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Round-trip</p>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Van: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>Departure:</span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['van_name']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['van_name']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Seats:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>Departure:</span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['seats']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p class="return"><?=$item[1]['seats']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Destination/Return Location:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>Departure:</span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['destination']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>

                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['destination']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Departure Date &amp; Time:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Return Date &amp; Time:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['departure_date']?></p>
                                        </div>
                                    </div>
                                </li>

                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Pickup Location: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>
                                                Departure:
                                            </span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['pickup_location']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['pickup_location']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Drop Location: </p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>
                                                Departure:
                                            </span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['drop_location']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['drop_location']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"># of Seats:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>
                                                Departure:
                                            </span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[0]['price']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item[1]['price']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                        <div class="children" style="width: 35%; padding: 0px 20px;">
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Price:</p>
                                        </div>
                                        <div class="children" style="width: 65%; padding-left: 40px;"><span>
                                                Departure:
                                            </span>
                                            <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">PHP <?=$item[0]['price']?></p>
                                            <div>
                                            <span>
                                                Return:
                                            </span>
                                                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">PHP <?=$item[1]['price']?></p>
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
                    <div class="body" style="padding: 15px 0px 0px;">
                        <ul class="pad-0 listn" style="padding: 0px; list-style-type: none;">
                            <li style="margin-bottom: 10px;">     
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Van Type</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['van_name']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Departure Date</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['departure_date']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Destination:</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['destination']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Trip type:</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=ucfirst((str_replace('_',' ',$item['trip_type'])))?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Total</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['price']?></p>
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
                    <div class="body" style="padding: 15px 0px 0px;">
                        <ul class="pad-0 listn" style="padding: 0px; list-style-type: none;">
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Package Name</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['package_name']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Adult Count</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['adult_count']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div  class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div  class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Rate</p>
                                    </div>
                                    <div  class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['rate']?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <div class="parent" style="display: -kit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
                                    <div class="children" style="width: 35%; padding: 0px 20px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;">Total</p>
                                    </div>
                                    <div class="children" style="width: 65%; padding-left: 40px;">
                                        <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px;"><?=$item['price']?></p>
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

<div class="total-price" style="    padding: 10px 0px; background: #515151;">
    <div class="parent" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-flex-flow: row wrap; justify-content: flex-start; flex-wrap: wrap;">
            <div class="children" style="width: 35%; padding: 0px 20px;">
                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px; color: #fff;">Total:</p>
            </div>
            <div class="children" style="width: 65%; padding-left: 40px;">
                <p style="font-family: Arial, sans-serif; font-size: 15px; word-break: break-word; margin: 0px; color: #fff;">PHP <?=number_format($total_price,2)?></p>
            </div>
    </div>
</div>
</div>