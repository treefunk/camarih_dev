<div class="book">

<section class="sec-1">
      <div class="overlay"></div>
</section>
<section class="sec-2">
    <div style="margin-bottom:100px">
    
        <h2><?=$labels[$offset]?></h2>
        <p>To select a seat, click on the number of the seat:</p>
        <a href="<?=base_url('availability/check')?>">
                    <button class="btn btn-info"><< Back</button>
                </a>           
        <ul class="parent pad-0 listn">
            <book-summary
            :book_data='<?=json_encode($data[$offset]['selected'])?>'
            >
    
            </book-summary>
            <li>
                <div class="van-hldr">
                    <form action="<?=base_url('availability/summary')?>" method="POST">
                    <seat-plan-selection
                    :seats_data='<?=json_encode($data[$offset]['seat_layout'])?>'
                    :seat_map='<?=json_encode($data[$offset]['seat_map'])?>'
                    :sels_data='<?=json_encode([])?>'
                    key="<?=$offset?>"
                    ></seat-plan-selection>

                    <?php if(count($data) > 1 && $offset != 1): ?>
                        <input type="hidden" name="is_roundtrip" value="true">
                    <?php endif; ?>
                    




                    </form>
                </div>
            </li>

                    
            
                
        </ul>
        
    </div>
    
    </div>
</section>

