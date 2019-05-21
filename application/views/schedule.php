<div class="check schedule">
    
    <section class="sec-1">
        <article class="hero"><h3>Trip Schedule</h3></article>
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">
    <div class="pckage_wrap">
        <div class="hldr">
            

            <div class="table-hldr">
                <?php if(count($schedules)): ?>
                <table class="table schedule-table" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Puerto Princesa - El Nido</th>
                            <th>El Nido- Puerto Princesa</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach($schedules as $sched): ?>
                        <tr>
                            <td>
                                <div class="text-center">
                                    <?=$sched->trip_num?><?=ordinalSuffix($sched->trip_num)?> Trip
                                </div>
                            </td>
                            <td>
                                <span class="title-moble">Puerto Princesa - El Nido</span>
                                <div class="text-right">
                                    <?=$sched->departure_time_pps?>
                                </div>
                            </td>
                            <td>
                                <span class="title-moble">El Nido- Puerto Princesa</span>
                                <div class="text-right">
                                    <?=$sched->departure_time_eln?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>


                </table>
                <?php endif; ?>
            </div>

            <p><?=$body?></p> 
        </div>




    </div>

</section>
</div>
