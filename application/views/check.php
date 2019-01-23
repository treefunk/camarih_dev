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
                                <label for="departure_from">From:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['from']?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="departure_to">To:</label>
                            </div>
                            <div class="children">
                                <p><?=$selected['to']?></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </article>
    </div>


    <div class="table-hldr">
        <table class="table" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Vacancy</th>
                    <th>Rate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    
                <?php foreach($available_trips as $trip): ?>

                <tr>
                    <td><?=format_datetime_string($trip->departure_date,'m/d/Y')?></td>
                    <td><?=format_datetime_string($trip->departure_date,'h:i A')?></td>
                    <td>0/12</td>
                    <td>PHP <?=$trip->rate_price?></td>
                    <td>
                        <form action="<?=base_url('availability/book/'.$trip->rate_id)?>" method="POST">
        
                        <!--                                     
                        <seat-plan-selection
                        :trip_availability = '<?php//json_encode($trip)?>'
                        ></seat-plan-selection> -->
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>


        </table>
    </div>
    
    
</section>

