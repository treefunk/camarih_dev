<div class="check">
    
    <section class="sec-1">
        <article class="hero"><h3>About Us</h3></article>
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">

    <div class="text-center">

<h1>Trip Schedule</h1>

<div class="table-hldr">
    
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
                    <?=$sched->trip_num?><?=ordinalSuffix($sched->trip_num)?>
                </td>
                <td><?=$sched->departure_time_pps?></td>
                <td><?=$sched->departure_time_eln?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>


    </table>
</div>
<p>We provide the most comfortable and relaxing experience for our valued customers with our brand new fully air-conditioned vans (TOYOTA GRANDIA). You can sit back and relax while travelling for we have neck pillow to make your trip
        more comfortable with matching harmonious and melodious music and complimentary snacks on board courtesy of&nbsp;<em>Baker's Hill Palawan</em> </p> 



</div>
</section>
</div>
