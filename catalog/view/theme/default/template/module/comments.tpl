<div class="comments-carousel">
	<div class="owl-carousel" id="carousel-comment">
		<?php if(!$comments) { echo "no comments"; } ?>
		<?php foreach ($comments as $comment) { ?>
		<div class="comment-item">
			<div class="comment-image"><img width="100" src="<?php echo '/image/'; if ($comment['image']) echo $comment['image']; ?>"/></div>
			<div class="comment-name"><?php echo $comment['name']; ?></div>
			<div class="comment-text"><?php echo $comment['text']; ?></div>
		</div>
		<?php } ?>
	</div>
</div>
<script>
$(document).ready(function() {
 
  $("#carousel-comment").owlCarousel({
	items: 2,
	autoPlay: 1000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: false,
	transitionStyle: 'fade'
	});
});
</script>
