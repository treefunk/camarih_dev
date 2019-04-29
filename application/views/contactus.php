<div class="check about-us">
    
    <section class="sec-1">
        <div class="overlay">
            
        </div>
        
    </section>

<section class="sec-2">
	<div class="abt-hldr">
    <?php require_once __DIR__. "/../partials/alert.php"; ?> 

        <contact-form
        site_key='<?=getenv("CAPTCHA_SITE_KEY")?>'
        ajax_url='<?=base_url('contact/send')?>'
        ></contact-form>


	</div>

</div>
</section>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
</script>