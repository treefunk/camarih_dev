<div class="check schedule">
    
    <section class="sec-1">
        <article class="hero"><h3>About Us</h3></article>
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">
    <div class="pckage_wrap">
        <div class="hldr">
            <h3>Trip Schedule</h3>

            <div class="table-hldr">
                <?php if(count($schedules)): ?>
                <table class="table" >
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
                                <div class="text-center">
                                    <?=$sched->departure_time_pps?>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <?=$sched->departure_time_eln?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>


                </table>
                <?php endif; ?>
            </div>

            <p>We provide the most comfortable and relaxing experience for our valued customers with our brand new fully air-conditioned vans (TOYOTA GRANDIA). You can sit back and relax while travelling for we have neck pillow to make your trip more comfortable with matching harmonious and melodious music and complimentary snacks on board courtesy of&nbsp;<em>Baker's Hill Palawan</em> </p> 
        </div>




    </div>

</section>
</div>
