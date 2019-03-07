<div class="vans">

    <section class="sec-1">
        <article class="hero">
            <h3>Our Vans</h3>
        </article>
        <div class="overlay"></div>

    </section>


    <book-a-trip
    :destinations='<?=json_encode($destinations)?>'
    ></book-a-trip>


    <section class="sec-2">
        <article class="itm-hldr">
            <aside class="equip-dnone">
                <img src="images/horizontal-equip.png">
            </aside>

    <?php foreach($vans as $van): ?>
            <div class="divider">
                <!-- //todo loop van gallery here -->
                <div class="owl-carousel owl-theme cars">
                    <?php foreach($van->van_gallery as $gallery) : ?>
                    <div class="item">
                        <aside>
                            <img src="<?=base_url("uploads/van_gallery/{$gallery->van_id}_{$gallery->image_name}")?>">
                        </aside>
                        <!-- <article>
                            <h4>sample1</h4>
                        </article> -->
                    </div>
                    <?php endforeach; ?>
                </div>
                <van-rent-form
                :van_data='<?=json_encode($van)?>'
                :origins_data='<?=json_encode($destinations)?>'
                :destinations_data='<?=json_encode($destinations)?>'
                form_url="<?=base_url("ourvans/rent/{$van->id}")?>"
                check_url="<?=base_url("ourvans/check_van_availability/{$van->id}")?>"
                >
                </van-rent-form>
                <!-- <div class="clearfix">
                    <div class="right_item">
                        <article class="details">
                            <h4><?=$van->name?></h4>
                            <p><?=array_reduce(explode(',',$van->seat_map),function ($a,$b){ return $a + $b; },0)?> - Seater</p>

                            <ul class="pad-0 listn">
                                <li>
                                    <h6>Date</h6>
                                    <input
                                    readonly
                                    style="
                                        max-width: 290px;
                                        width: 100%;
                                        border: 2px solid #e1e1e1;
                                        height: 40px;
                                        padding-left: 15px;
                                        margin-bottom: 25px;
                                        background-image: url(../images/select-gray.png);
                                        background-repeat: no-repeat;
                                        background-position: 95% center;
                                        background-size: 15px;
                                        font-size: 18px;"
                                    type="date" name="" id="">
                                </li>
                                
                                <li>
                                    <h6>Select Origin</h6>
                                    <select name="destination_id" id="desination_id">
                                        <?php foreach($destinations as $destination): ?>
                                            <option value="<?=$destination->id?>"><?=$destination->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                                <li>
                                    <h6>Select a Destination</h6>
                                    <select name="destination_id" id="desination_id">
                                        <?php foreach($destinations as $destination): ?>
                                            <option value="<?=$destination->id?>"><?=$destination->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                                <li>
                                    <ul class="pad-0 listn">
                                        <li>
                                            <input type="radio" id="test1" name="radio-group">
                                            <label for="test1">Round Trip</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="test2" name="radio-group">
                                            <label for="test2">Round Trip</label>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <h5>Adults</h5>
                                    <input type="number">
                                    <span>PHP <?=number_format($van->oneway_rate)?></span>
                                </li>
                            </ul>
                        </article>
                        <div class="btm_link">
                            <ul class="pad-0 listn">
                                <li>
                                    <a href="#prcing_table" class="popup-with-form">Pricing Table</a>
                                </li>
                                <li>
                                    <a href="">Add to Cart</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div> -->
            </div>
        <?php endforeach; ?>

        </article>

    </section>










</div>