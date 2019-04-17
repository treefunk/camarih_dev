<div class="check about-us">
    
    <section class="sec-1">
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">
	<div class="abt-hldr">
		<h3>Payment successfully Verified. </h3>
        <div class="text-center">
            <p>Thank you for booking with us! <a href="<?=base_url()?>">Go Back to Home</a></p>
        </div>
        <?php if(isset($_SESSION['item_list'])): ?>
            <?=$_SESSION['item_list']?>
        <?php endif; ?>
	</div>

</div>
</section>
</div>
