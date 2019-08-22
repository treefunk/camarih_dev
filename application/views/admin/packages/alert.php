
<?php //Handles session types of error $_SESSION['alert'] ?>

<?php if(isset($_SESSION['alert']['type'])): ?>
<div class="alert alert-<?=$_SESSION['alert']['type']?> alert-block fade in">
    <button data-dismiss="alert" class="close close-sm" type="button">
        <i class="fa fa-times"></i>
    </button>
    <?php $type = $_SESSION['alert']['type']; ?>

    <?php if(in_array($type,['success','danger'])): ?>
    <h4>
        <i class="fa fa-ok-sign"></i>
        <?php
            
            if($type == 'success'){
                echo "Success!";
            }elseif($type == 'info'){
                echo "";
            }else{
                echo "Error";
            }
        ?>
    </h4>
    <?php endif; ?>
    <ul>
        <p><?=$_SESSION['alert']['message']?></p>
    </ul>
</div>

<?php endif; ?>

<?php //Handles error variables passed from controller to view : $data['errors'] ?>

<?php if(isset($errors)): ?>
<div class="alert alert-danger alert-block fade in">
    <button data-dismiss="alert" class="close close-sm" type="button">
        <i class="fa fa-times"></i>
    </button>
    <h4>
        <i class="fa fa-ok-sign"></i>
        Errors
    </h4>
    <?php if(is_array($errors)): ?>
    <ul>
            <?php foreach($errors as $error): ?>
                <li><?=$error?></li>
            <?php endforeach; ?>
    </ul>
    <?php else: ?>
            <?=$errors?>
    <?php endif; ?>
</div>
<?php endif; ?>