<div class="check departure-trip van--">

<section class="sec-1">
      <div class="overlay"></div>
      <!-- <aside>
        <img src="<?=base_url()?>frontend/images/island.jpg">
      </aside> -->
        
</section>


<section class="sec-2">
    
    <div class="item">
            <article class="hldr">
                <ul class="pad-0 listn">
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="destination_from">Origin:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['origin']->name?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="departure_to">Destination:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['destination']->name?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="departure_from">Departure Date:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['from']?></p>
                            </div>
                        </div>
                    </li>
                    <?php if(isset($selected['to'])): ?>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="departure_to">Return Date:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['to']?></p>
                            </div>
                        </div>
                    </li>
                    <?php endif ?>
                </ul>
            </article>
    </div>
    <?php
    $book = true;
    $notrips = false;
    if(count($available_trips) == 1){
        if(!count($available_trips[0])){
            $book = false;
            $notrips = true;
            $errormessage = "No Available trips found";
            require_once "partials/no_trips_found.php";
        }
    }

    if(count($available_trips) == 2 && (!count($available_trips[0]) || !count($available_trips[1]))){

        $book= false;
        $when = [];
        if(!count($available_trips[0])){
            $when[] = "Departure";
        }
        if(!count($available_trips[1])){
            $when[] = "Return";
        }

        $not_available = implode(" and ",$when);
        $errormessage = "No Available trips found for {$not_available}";
        require_once "partials/no_trips_found.php";
    }
    ?>


    <form action="<?=base_url('availability/book_departure/')?>" method="post">
    <?php if(count($available_trips[0]) && $book): ?>
    <div class="table-hldr">
    <div class="text-center">
        <h1>Departure trip</h1>
    </div>
        <table class="table" >
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Van Name</th>
                    <th>Vacancy</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php $first=null; foreach($available_trips[0] as $trip): ?>

                <tr>
                    <td><?=$trip->departure_time?></td>
                    <td><?=$trip->van_name?></td>
                    <td><?=$trip->occupied_seats?> / <?=$trip->total_seats?></td>
                    <td>
                        <?php if($trip->occupied_seats != $trip->total_seats):  ?>
                        <div class="radio"><label for="rate_<?=$trip->id?>"><input type="radio" name="rate[0]" id="rate_<?=$trip->id?>" <?=$first!=true ? "checked" : null?> value="<?=$trip->rate_id?>" style="-webkit-appearance: radio;">PHP
                                <?=$trip->rate_price?></label></div>
                        <?php else: ?>
                        FULL
                        <?php endif;?>
                        
                    </td>
                </tr>

            <?php $first=true; endforeach; ?>

            </tbody>


        </table>
    </div>
    <?php endif; ?>
    <?php if(count($available_trips) == 2): ?>
    <?php if(count($available_trips[1]) && $book): ?>
    <div class="table-hldr">
    <div class="text-center">
        <h1>Return trip</h1>
    </div>
        <table class="table" >
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Van Name</th>
                    <th>Vacancy</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php $second=null; foreach($available_trips[1] as $trip): ?>

                <tr>
                    <td><?=$trip->departure_time?></td>
                    <td><?=$trip->van_name?></td>
                    <td><?=$trip->occupied_seats?> / <?=$trip->total_seats?></td>
                    <td>
                    <?php if($trip->occupied_seats != $trip->total_seats): ?>
                        <div class="radio"><label for="rate_return_<?=$trip->id?>"><input type="radio" name="rate[1]" id="rate_return_<?=$trip->id?>" <?=$second!=true ? "checked" : null?> value="<?=$trip->rate_id?>" style="-webkit-appearance: radio;">PHP
                                <?=$trip->rate_price?></label></div>
                        <?php else: ?>
                        FULL
                        <?php endif;?>
                        
                    </td>
                </tr>

            <?php $second=true; endforeach; ?>

            </tbody>


        </table>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <div class="btn-holder clearfix <?=($notrips ? 'single-button' : '')?>">
        <a href="<?=base_url()?>" class="left">
                <button class="btn-gray" type="button">Book Another Trip</button>
        </a>
        <?php if($book): ?>
            <button type="submit" class="btn-green right">Book Now</button>
        <?php endif; ?>
            
    </div>
    
    </form>
    
</section>

