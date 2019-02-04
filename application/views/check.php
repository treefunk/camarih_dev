<div class="check">

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
    <form action="<?=base_url('availability/book/')?>" method="post">
    <div class="table-hldr">
    
        <table class="table" >
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Vacancy</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($available_trips[0] as $trip): ?>

                <tr>
                    <td><?=$trip->departure_time?></td>
                    <td><?=$trip->occupied_seats?> / <?=$trip->total_seats?></td>
                    <td>
                        <?php if($trip->occupied_seats != $trip->total_seats): ?>
                        <div class="radio"><label for=""><input type="radio" name="rate[0]" id="optionsRadios1" value="<?=$trip->rate_id?>" style="-webkit-appearance: radio;">PHP
                                <?=$trip->rate_price?></label></div>
                        <?php else: ?>
                        FULL
                        <?php endif;?>
                        
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>


        </table>
    </div>
    <?php if(count($available_trips) == 2): ?>
    <h1>Return Date</h1>
    <div class="table-hldr">
        <table class="table" >
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Vacancy</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($available_trips[1] as $trip): ?>

                <tr>
                    <td><?=$trip->departure_time?></td>
                    <td><?=$trip->occupied_seats?> / <?=$trip->total_seats?></td>
                    <td>
                    <?php if($trip->occupied_seats != $trip->total_seats): ?>
                        <div class="radio"><label for=""><input type="radio" name="rate[1]" id="optionsRadios1" value="<?=$trip->rate_id?>" style="-webkit-appearance: radio;">PHP
                                <?=$trip->rate_price?></label></div>
                        <?php else: ?>
                        FULL
                        <?php endif;?>
                        
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>


        </table>
    </div>
    <?php endif; ?>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Book Now</button>
        </div>
    </form>
    
</section>

