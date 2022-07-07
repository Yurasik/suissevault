<?php if ( is_cart() ):
	$storage_information = get_field( 'storage_information', 'options' ); ?>
	<!-- Modal-allocated. -->
	<div class="modal modal-allocated">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> <?php echo $storage_information['title']; ?>
			</div>
			<div class="modal_scroll">
				<?php echo $storage_information['text']; ?>
				<a class="modal_more hover__line" href="<?php echo home_url( '/storage-information/' ); ?>">View more storage information</a>
				<div class="flex__center">
					<picture>
						<source srcset="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.webp" type="image/webp">
						<img src="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.png" alt srcset="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.png 1x, <?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks@2x.png 2x">
					</picture>
					<div class="btn close-btn">Ok</div>
				</div>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-allocated. -->
<?php endif; ?>