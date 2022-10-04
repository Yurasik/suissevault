<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after
 *
 * @package suissevault
 */

$contacts = get_field( 'contacts', 'options' );
$footer = get_field( 'footer', 'options' );
?>

<?php get_template_part( 'template-parts/modal/auth' ) ?>

<?php get_template_part( 'template-parts/modal/identification' ) ?>

<?php get_template_part( 'template-parts/modal/storage' ) ?>

<?php get_template_part( 'template-parts/modal/account' ) ?>

<!-- Footer. -->
<div class="footer">
	<div class="bone">
		<div class="footer_net flex__start">
			<?php if ( $footer[ 'logo' ] || $footer[ 'text' ] ) :
				$picture = suissevault_get_picture_html( $footer[ 'logo' ] ); ?>
				<div class="footer_column">
					<?php if ( $footer[ 'logo' ] ): ?>
						<div class="footer_logo">
							<?php echo $picture; ?>
						</div>
					<?php endif; ?>
					<p><?php echo "$footer[text]"; ?></p>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-1' ) ): ?>
				<?php dynamic_sidebar( 'footer-1' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ): ?>
				<?php dynamic_sidebar( 'footer-2' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ): ?>
				<?php dynamic_sidebar( 'footer-3' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-4' ) ): ?>
				<?php if ( ( !is_user_logged_in() ) ): ?>
					<?php dynamic_sidebar( 'footer-4' ); ?>
				<?php else :
					$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
					$myaccount_title = get_the_title( $myaccount_page_id );
					?>
					<div class="footer_column widget widget_nav_menu">
						<div class="subtitle">Account</div>
						<div class="menu-account-container">
							<ul id="menu-account" class="nav">
								<li class="menu-item">
									<a href="<?php echo get_permalink( $myaccount_page_id ); ?>" title="<?php echo $myaccount_title; ?>"><?php echo $myaccount_title; ?></a>
								</li>
								<li class="menu-item">
									<a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
								</li>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="footer_column">
				<?php get_template_part( 'template-parts/social', 'links' ); ?>
				<ul class="footer_hrefs">
					<li class="icon icon-tel">
						<a href="tel:<?php echo "$contacts[phone]"; ?>" class="hover__line"><?php echo "$contacts[phone]"; ?></a>
					</li>
					<li class="icon icon-time"><?php echo abbreviated_days_of_the_week( $contacts[ 'working_days' ] ) . ": $contacts[working_hours]"; ?></li>
					<li class="icon icon-mail">
						<a href="mailto:<?php echo "$contacts[email]"; ?>" class="hover__line"><?php echo "$contacts[email]"; ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer_bottom">
		<div class="bone">
			<div class="footer_net flex__center">
				<div class="footer_cop">
					<?php echo "$footer[copyright]"; ?>
				</div>

				<?php if ( $footer[ 'payments' ] ): ?>
					<ul class="footer_pay flex__align">
						<?php foreach ( $footer[ 'payments' ] as $payment ) {
							echo suissevault_get_picture_html( $payment[ 'payment' ] );
						} ?>
					</ul>
				<?php endif; ?>

				<div>
					<?php echo get_acf_link_html( $footer[ 'privacy_link' ], "footer_policy hover__line" ); ?>
					<?php echo get_acf_link_html( $footer[ 'terms_link' ], "footer_policy hover__line" ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer. -->

<?php wp_footer(); ?>

</body>
</html>