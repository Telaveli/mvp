<div class="mvp-carousel">
	<div class="owl-carousel" id="carousel-mvp">
		<?php if(!$mvp) { echo "no mvp"; } ?>
		<?php foreach ($mvp as $mvp) { ?>
		<div class="mvp-item">
			<div class="mvp-image"><img width="100" src="<?php echo '/image/'; if ($mvp['image']) echo $mvp['image']; ?>"/></div>
			<div class="mvp-name"><?php echo $mvp['name']; ?></div>
			<div class="mvp-text"><?php echo $mvp['text']; ?></div>
		</div>
		<?php } ?>
	</div>
</div>
<script>
$(document).ready(function() {

  $("#carousel-mvp").owlCarousel({
	items: 2,
	autoPlay: 1000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: false,
	transitionStyle: 'fade'
	});
});
</script>
