<?php
/**
 * Template Name: Personal Area
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page cabinet">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<!--<div class="cabinet_net grid">
				<div class="cabinet_bar">
					<ul>
						<li>
							<a class="cabinet_bar_li active" href="/cabinet">My Account</a>
						</li>
						<li>
							<a class="cabinet_bar_li" href="/cabinet/order">Order history</a>
						</li>
						<li>
							<a class="cabinet_bar_li" href="/cabinet/change">Change Password</a>
						</li>
						<li>
							<a class="cabinet_bar_li" href="/cabinet/storage">Storage</a>
						</li>
						<li>
							<a class="cabinet_bar_li" href="/cabinet/billing">Billing & Payments</a>
						</li>
						<li>
							<a class="cabinet_bar_li" href="/cabinet/refer">Refer a friend</a>
						</li>
						<li>
							<div class="cabinet_bar_li">Exit</div>
						</li>
					</ul>
				</div>
				<div class="cabinet_content cabinet_account">
					<h2>My Account</h2>
					<form class="form">
						<div class="grid grid__twoo">
							<div class="form_wrapper">
								<div class="form_label">First name</div>
								<div class="input">
									<input type="text">
									<span class="error_text">Error text</span>
								</div>
							</div>
							<div class="form_wrapper">
								<div class="form_label">email</div>
								<div class="input">
									<input type="text">
									<span class="error_text">Error text</span>
								</div>
							</div>
							<div class="form_wrapper">
								<div class="form_label">Last Name</div>
								<div class="input">
									<input type="text">
									<span class="error_text">Error text</span>
								</div>
							</div>
							<div class="form_wrapper">
								<div class="form_label">Phone</div>
								<div class="input">
									<input type="text">
									<span class="error_text">Error text</span>
								</div>
							</div>
						</div>
						<div class="btn btn-line">save changes</div>
					</form>
				</div>
			</div>-->

			<div class="cabinet_net grid">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

<?php get_footer();