<?php if (@$_GET['dev']): ?>
  <book-a-trip-new
  url='<?=base_url('availability/check')?>'
  :destinations_data='<?=json_encode($destinations)?>'
  :origins_data='<?=json_encode($origins)?>'
  check_avail_url='<?=base_url('availability/check_selling_dates')?>'
  > </book-a-trip-new>
<?php else: ?>
  <book-a-trip
  url='<?=base_url('availability/check')?>'
  :destinations_data='<?=json_encode($destinations)?>'
  :origins_data='<?=json_encode($origins)?>'
  > </book-a-trip>
<?php endif ?>