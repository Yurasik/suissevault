<?php if ( get_field( 'contact_us_display' ) ):
	$contacts = get_field( 'contacts', 'options' ); ?>
	<div class="contacts_block">
		<div class="bone">
			<div class="contacts_block_net flex__center">
				<div class="contacts_block_map">
					<iframe src="<?php echo "$contacts[google_map]"; ?>" width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
				<div class="contacts_block_info">
					<div class="subtitle"><?php _e( 'Contact Us', 'suissevault' ); ?></div>
					<h2>Call <?php echo "$contacts[phone]"; ?></h2>
					<h2><i><?php echo "$contacts[city]"; ?></i></h2>
					<p><?php echo "$contacts[address]"; ?><br>
						<?php echo "$contacts[quarter_of_office_buildings]"; ?><br>
						<?php echo "$contacts[working_days] $contacts[working_hours]"; ?><br>
						<?php echo "$contacts[admission_conditions]"; ?> </p>
					<a href="<?php echo "$contacts[google_map_link]"; ?>" class="more-line">see on the map</a>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>