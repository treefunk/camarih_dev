<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <div style="margin-bottom:100px">
    
            <div id="legend">
                    <h2><?=$label?></h2>
                <p>Please tap or click your choice of seat:</p>
                <ul class="pad-0 listn">
                    <li>
                        <h6 class="available" data-badge="27"> Available </h6>
                    </li>
                    <li>
                        <h6 class="occupied" data-badge="27"> Occupied </h6>
                    </li>
                    <li>
                        <h6 class="selectedseat" data-badge="27"> Selected </h6>
                    </li>
                    <li>
                        <h6 class="selectedincart" data-badge="27"> Selected in Cart</h6>
                    </li>
                </ul>
            </div>
        <a href="<?=$back_url?>">
                    <button class="btn btn-gray"><i class="fa fa-angle-left"></i>Back</button>
                </a>           
        <ul class="parent pad-0 listn mainlist">
            <book-summary
            :book_data='<?=json_encode($selected)?>'
            >
            </book-summary>
            <li>
                <div class="van-hldr">
                    <form action="<?=$post_url?>" method="POST">
                    <seat-plan-selection
                    :seats_data='<?=json_encode($seat_layout)?>'
                    :seat_map='<?=json_encode($seat_map)?>'
                    :sels_data='<?=json_encode([])?>'
                    seats_length_class='<?=$seats_length_class?>'
                    :booking_information_data='<?=json_encode($booking_information)?>'
                    key="<?=$offset?>"
                    ></seat-plan-selection>

                    <?php //if(count($data) > 1 && $offset != 1): ?>
                        <!-- <input type="hidden" name="is_roundtrip" value="true"> -->
                    <?php //endif; ?>
                    

                    </form>
                </div>
            </li>

                    
            
                
        </ul>
        
    </div>
    
    </div>
</section>

