<div class="investment_categiry">
	<div class="investment_categiry_title"><?php _e( 'Categories', 'suissevault' ); ?></div>
	<ul>
		<?php wp_list_categories( [
			'echo'                => true,
			'hide_title_if_empty' => true,
			'use_desc_for_title'  => false,
			'title_li'            => '',
			'show_count'          => '1',
		] ); ?>
	</ul>
</div>