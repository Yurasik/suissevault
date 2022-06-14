<?php
/**
 * Template Name: Contact Us
 *
 * @package suissevault
 */

get_header();

$contacts    = get_field( 'contacts', 'options' );
$contact_faq = get_field( 'contact_faq' );
$contact_details = get_field( 'contact_details' );
?>

	<div class="page contact">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<div class="contact_net flex__start">
				<?php the_content(); ?>

				<div class="contact_faq">
					<?php if ( has_post_thumbnail() ) {
						echo suissevault_get_picture_html( get_post_thumbnail_id() );
					} ?>
					<div>
						<?php echo $contact_faq; ?>
					</div>
				</div>
			</div>

			<?php echo $contact_details; ?>

			<div class="contacts_map">
				<iframe src="<?php echo "$contacts[google_map]"; ?>" width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>

			<div class="contacts_pos flex__align">
				<h2><i><?php echo "$contacts[city]"; ?></i></h2>
				<p><?php echo "$contacts[address], $contacts[quarter_of_office_buildings]"; ?></p>
			</div>

			<div class="contacts_bottom flex">
				<div class="contacts_column">
					<div class="subtitle"><?php _e( 'Working hours', 'suissevault' ); ?></div>
					<p><?php echo abbreviated_days_of_the_week( $contacts[ 'working_days' ] ) . ": $contacts[working_hours]"; ?>
						<br><?php echo "$contacts[admission_conditions]"; ?></p>
				</div>
				<div class="contacts_column">
					<div class="subtitle"><?php _e( 'social networks', 'suissevault' ); ?></div>
					<?php get_template_part( 'template-parts/social', 'links' ); ?>
				</div>
				<div class="contacts_column">
					<div class="subtitle"><?php _e( 'Phone', 'suissevault' ); ?></div>
					<a href="tel:<?php echo "$contacts[phone]"; ?>" class="hover__line"><?php echo "$contacts[phone]"; ?></a>
				</div>
				<div class="contacts_column">
					<div class="subtitle"><?php _e( 'Email', 'suissevault' ); ?></div>
					<a class="hover__line-active _mail" href="mailto:<?php echo "$contacts[email]"; ?>"><?php echo "$contacts[email]"; ?></a>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();