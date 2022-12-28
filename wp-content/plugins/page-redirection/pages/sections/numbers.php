<?php
	$titles = ['Today', 'This week', 'This month', 'This year', 'Whole Period'];
	$id     = ['value-24h-change', 'value-1w-change', 'value-1m-change', 'value-1y-change','value-all-change'];
?>


<div class="rp-numbers">

		<div class="rb-numbers-container">
			
			<?php
			for ($i=0; $i < count($titles); $i++) { ?>
				<div class="rb-numbers-box" data-aos="zoom-in" data-aos-delay="<?= 300 * ($i/2) ?>">
					<p class="rb-numbers-box-title"><?= $titles[$i] ?></p>
					<p id="<?= $id[$i] ?>" class="rb-numbers-box-value">0</p>
				</div> <!-- .rb-numbers-box -->
			<?php }?>


		</div> <!-- .rb-numbers-container -->

</div> <!-- .rp-numbers -->