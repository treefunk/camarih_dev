<div class="check schedule">
    
    <section class="sec-1">
        <article class="hero"><h3>Rates</h3></article>
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">
    <div class="pckage_wrap">
        <div class="hldr">
            <div class="table-hldr">
                <?php if(count($rates)): ?>
                    <?php foreach ($rates as $rate): ?>
                        <h3 <?php echo ($key != 0)?'style="margin-top: 50px;"':'';  ?>><?php echo $rate->name ?></h3>
                        <center><p><?php echo $rate->description ?></p></center>
                        <table class="table schedule-table" >
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>One Way Rate <?php echo ($rate->name == 'Regular Van') ? '<br>per person': '' ?></th>
                                    <th>Round Trip Rate <?php echo ($rate->name == 'Regular Van') ? '<br>per person': '' ?></th>
                                </tr>
                            </thead>
                            <tbody>

                           <?php foreach($rate->van_rates as $van_rate): ?>
                                <tr>
                                    <td>
                                        <div class="text-center">
                                            <?php echo $van_rate->origin->name ?> - <?php echo $van_rate->destination->name ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="title-moble">P<?php echo number_format($van_rate->oneway_rate); ?>.00</span>
                                        <div class="text-right">
                                            P<?php echo number_format($van_rate->oneway_rate); ?>.00
                                        </div>
                                    </td>
                                    <td>
                                        <span class="title-moble">P<?php echo number_format($van_rate->roundtrip_rate); ?>.00</span>
                                        <div class="text-right">
                                            P<?php echo number_format($van_rate->roundtrip_rate); ?>.00
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>


                        </table>
                        
                    <?php endforeach ?>
                <?php endif; ?>
            </div>

            <p><?php #echo $body?></p> 
        </div>




    </div>

</section>
</div>
