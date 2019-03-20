<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <div style="margin-bottom:100px">
    
        <h2><?=$label?></h2>
        <p>Please tap or click your choice of seat:</p>
        <a href="<?=$back_url?>">
                    <button class="btn btn-info"><< Back</button>
                </a>           
        <ul class="parent pad-0 listn">
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

