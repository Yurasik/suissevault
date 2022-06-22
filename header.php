<?php
/**
 * The header for our theme.
 * Displays all of the <head> section
 *
 * @package suissevault
 */
session_start();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<title><?php bloginfo( 'name' ); ?></title>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/safari-pinned-tab.svg">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/favicon.ico">
	<!-- Favicon -->

	<!-- Open Graph. -->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
	<meta property="og:url" content="https://suisse.knott.fun">
	<meta property="og:locale" content="<?php echo ( get_locale() ) ? explode( '_', get_locale() )[ 0 ] : "en"; ?>">
	<meta property="og:title" content="<?php bloginfo( 'name' ); ?> | <?php the_title(); ?>">

	<!-- <meta property="og:description" content=""> -->
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicons/android-chrome-512x512.png">
	<meta property="og:image:width" content="800">
	<meta property="og:image:height" content="800">
	<!-- Open Graph. -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Header. -->
<?php
$header = get_field( 'header', 'options' );
$header_class = is_front_page() ? "" : "header-black"; ?>
<div class="header <?php echo $header_class; ?>">
	<div class="bone">
		<div class="header_net flex__center">
			<div class="header_left flex__align">
				<div class="header_burger">
					<span></span> <span></span> <span></span>
				</div>
				<div class="header_search">
					<div class="search flex__align">
						<button>
							<svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19.6959 18.2168L14.7656 13.2662C16.0332 11.8113 16.7278 9.98069 16.7278 8.07499C16.7278 3.62251 12.9757 0 8.36391 0C3.75212 0 0 3.62251 0 8.07499C0 12.5275 3.75212 16.15 8.36391 16.15C10.0952 16.15 11.7451 15.6458 13.1557 14.6888L18.1235 19.677C18.3311 19.8852 18.6104 20 18.9097 20C19.193 20 19.4617 19.8957 19.6657 19.7061C20.0992 19.3034 20.113 18.6357 19.6959 18.2168ZM8.36391 2.10652C11.7727 2.10652 14.5459 4.78391 14.5459 8.07499C14.5459 11.3661 11.7727 14.0435 8.36391 14.0435C4.95507 14.0435 2.18189 11.3661 2.18189 8.07499C2.18189 4.78391 4.95507 2.10652 8.36391 2.10652Z" fill="var(--color)"/>
							</svg>
						</button>
						<input class="input__search" type="text" name="s" placeholder="<?php _e( 'Search...', 'suissevault' ); ?>">
					</div>
				</div>
			</div>
			<div class="header_logo">
				<svg>
					<image href="<?php echo "$header[logo]"; ?>"/>
				</svg>
			</div>
			<div class="header_right flex__align">
				<?php
				$api_currency = ( isset( $_SESSION[ 'suissevault_api_currency' ] ) ) ? $_SESSION[ 'suissevault_api_currency' ] : "GBP";
				$api_metal = ( isset( $_SESSION[ 'suissevault_api_metal' ] ) ) ? $_SESSION[ 'suissevault_api_metal' ] : 'gold';
				$api_price = ( isset( $_SESSION[ 'suissevault_api_currency' ] ) ) ? get_api_price( $_SESSION[ 'suissevault_api_currency' ] ) : get_api_price();
				?>
				<div class="header_price">
					<div class="header_price_top flex__align">
						<div class="header_price_metal">
							<div class="select">
								<?php $metals = [
									'Gold'   => 'gold',
									'Silver' => 'silver',
								]; ?>
								<select name="metal">
									<?php foreach ( $metals as $metal_name => $metal_value ):
										$selected = ( $metal_value == $api_metal ) ? "selected" : ""; ?>
										<option value="<?php echo "$metal_value"; ?>" <?php echo $selected; ?>><?php echo $metal_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="header_price_currency flex__align">
							<svg class="header_currency <?php echo ( $api_currency == "GBP" ) ? "active" : ""; ?>" data-name="GBP" width="28" height="28" viewbox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.8012 18.7464L18.8016 18.7476L18.7035 18.7691C18.6505 18.7776 18.6071 18.7899 18.5674 18.8091L18.5261 18.8244C17.8742 19.155 17.1868 19.3247 16.4921 19.3247C16.3661 19.3247 16.1297 19.2913 15.7894 19.2255C15.4497 19.1672 15.0799 19.1018 14.6841 19.0303C14.289 18.9589 13.9007 18.8908 13.5203 18.8252C13.1363 18.759 12.8393 18.7273 12.6126 18.7273C12.4525 18.7273 12.2903 18.735 12.1302 18.7502L11.4465 18.8154L11.9138 18.3122C11.9607 18.262 12.0049 18.2119 12.0475 18.1622C12.2569 17.9173 12.4305 17.6588 12.5635 17.3929C12.6962 17.127 12.7935 16.8341 12.8524 16.5214C12.9113 16.2079 12.9415 15.8545 12.9415 15.471C12.9415 15.2961 12.921 15.1225 12.8804 14.9545L12.8024 14.6318L15.414 14.6267C15.4603 14.6228 15.5001 14.6123 15.5389 14.5943C15.8284 14.5 16.0159 14.2442 16.0159 13.9538C16.0159 13.63 15.7845 13.3527 15.4652 13.294C15.442 13.2889 15.421 13.2861 15.3998 13.2855L15.3968 13.2857C15.3887 13.2855 15.3823 13.2853 15.3773 13.285L15.3433 13.2874H12.4797L12.4223 13.1038C12.1217 12.1395 11.9697 11.325 11.9697 10.6825C11.9697 10.3682 12.0284 10.0654 12.1442 9.78249C12.2599 9.50049 12.4212 9.24868 12.6237 9.03437C12.8249 8.82099 13.0735 8.65074 13.3626 8.52849C13.6508 8.40681 13.9778 8.34493 14.334 8.34493C15.7836 8.34493 16.5505 9.0338 16.6783 10.4509C16.6806 10.4586 16.6823 10.4667 16.6838 10.4747L16.6888 10.5389L16.687 10.5522C16.6885 10.5812 16.6967 10.6257 16.7136 10.678C16.7813 11.1285 17.146 11.4449 17.584 11.4449C18.0373 11.4449 18.4116 11.0999 18.4585 10.6587H18.4581L18.4633 10.5377C18.4635 10.5359 18.4616 10.5212 18.4609 10.5049L18.4605 10.4856C18.4095 9.92311 18.2734 9.4163 18.0574 8.98318C17.8414 8.55174 17.5555 8.18518 17.2082 7.894C16.8598 7.6015 16.4406 7.37706 15.9632 7.22687C15.4849 7.07631 14.9515 7 14.3785 7C13.758 7 13.1847 7.08981 12.6741 7.267C12.1628 7.44437 11.7182 7.7005 11.3532 8.0275C10.987 8.35543 10.6982 8.7638 10.495 9.24137C10.2914 9.71986 10.188 10.2614 10.188 10.8518C10.188 11.13 10.2255 11.473 10.2996 11.8709C10.3577 12.186 10.4464 12.55 10.5636 12.9529L10.6607 13.2876L9.1718 13.2844C8.83074 13.3167 8.56281 13.6047 8.56281 13.9542C8.56281 14.2973 8.82212 14.583 9.16562 14.619L9.22974 14.6307L11.0472 14.6322L11.0922 14.8378C11.161 15.1545 11.196 15.4789 11.196 15.8012C11.196 16.2754 11.1509 16.7012 11.0618 17.0657C10.9731 17.4293 10.8439 17.7561 10.6774 18.0358C10.5113 18.3144 10.3052 18.5616 10.0641 18.7697C9.8243 18.9773 9.54586 19.164 9.23762 19.3238C8.74074 19.4889 8.18593 19.7882 8.28006 20.3119C8.35693 20.7396 8.76418 21.0508 9.19843 20.9932C9.21155 20.991 9.21193 20.9908 9.22337 20.9854C10.4374 20.4319 11.5399 20.1527 12.5059 20.1527C12.631 20.1527 12.8057 20.1737 13.0251 20.2153C13.2448 20.2569 13.488 20.3079 13.7479 20.3676C14.0095 20.4266 14.2802 20.4919 14.5594 20.5635C14.8388 20.6348 15.1077 20.7002 15.3664 20.7594C15.6252 20.8189 15.8612 20.8714 16.0751 20.9158C16.29 20.9604 16.4558 20.9822 16.5814 20.9822H16.6196C17.5954 20.9822 18.6313 20.5742 18.6752 20.5568C18.7708 20.5151 19.0633 20.4066 19.0633 20.4066C19.5278 20.3012 19.8131 19.8504 19.7117 19.3982C19.6196 18.9876 19.2212 18.7018 18.8012 18.7464Z" fill="var(--color)"/>
								<circle cx="14" cy="14" r="13.5" stroke="var(--color)"/>
							</svg>
							<svg class="header_currency <?php echo ( $api_currency == "USD" ) ? "active" : ""; ?>" data-name="USD" width="28" height="28" viewbox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<circle cx="14" cy="14" r="13.5" stroke="var(--color)"/>
								<path d="M14.6181 13.1252V10.0145C15.2836 10.1267 15.9111 10.3998 16.4475 10.8098C16.5544 10.8832 16.6799 10.923 16.8098 10.9247C17.2261 10.9247 17.5654 10.5898 17.5698 10.1736C17.5707 9.99505 17.5009 9.8236 17.3754 9.69634C16.6004 9.03265 15.6283 8.64117 14.6093 8.58284V7.54002C14.6093 7.24219 14.3681 7.00094 14.0702 7.00094C14.064 7.00006 14.0578 7.00006 14.0517 7.00006C13.7494 6.99563 13.5002 7.23691 13.4958 7.54002V8.54749C11.5074 8.68888 10.1553 9.91728 10.1553 11.5522C10.1553 13.5582 11.8609 14.115 13.4958 14.5569V18.0918C12.6332 17.9761 11.8202 17.6182 11.1539 17.0579C11.0284 16.958 10.8728 16.9023 10.712 16.8988C10.3046 16.9271 9.99088 17.2682 9.99616 17.6765C9.99528 17.855 10.0651 18.0265 10.1906 18.1537C11.1035 18.9756 12.2771 19.4484 13.5046 19.4882V20.4603C13.5046 20.4664 13.5055 20.4726 13.5055 20.4788C13.5196 20.7811 13.7768 21.0144 14.079 20.9993C14.3768 20.9993 14.6181 20.7581 14.6181 20.4603V19.4705C17.0307 19.3114 18.0028 17.8444 18.0028 16.289C18.0028 14.2034 16.2531 13.5671 14.6181 13.1252ZM13.5046 12.8424C12.5414 12.5596 11.7902 12.268 11.7902 11.4461C11.7902 10.6243 12.4707 10.0322 13.5046 9.95264V12.8424V12.8424ZM14.6181 18.1095V14.8927C15.6168 15.1755 16.3944 15.5555 16.3856 16.4834C16.3856 17.1551 15.9261 17.9504 14.6181 18.1095Z" fill="var(--color)"/>
							</svg>
							<svg class="header_currency <?php echo ( $api_currency == "EUR" ) ? "active" : ""; ?>" data-name="EUR" width="28" height="28" viewbox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<circle cx="14" cy="14" r="13.5" stroke="var(--color)"/>
								<path d="M19.1114 18.0844C18.2844 18.9542 17.2256 19.4334 16.13 19.4334C14.3343 19.4334 12.7794 18.1723 12.0476 16.3494H17.0356C17.4681 16.3494 17.8188 15.9988 17.8188 15.5662C17.8188 15.1337 17.4681 14.783 17.0356 14.783H11.6496C11.6188 14.527 11.602 14.2658 11.602 13.9998C11.602 13.6998 11.6231 13.4057 11.6625 13.1187H17.0356C17.4681 13.1187 17.8188 12.768 17.8188 12.3355C17.8188 11.903 17.4681 11.5522 17.0356 11.5522H12.0893C12.8368 9.78274 14.3668 8.56624 16.13 8.56624C17.2256 8.56624 18.2844 9.04542 19.1114 9.91519C19.4091 10.2285 19.9046 10.2414 20.2186 9.9434C20.5321 9.64529 20.5445 9.14955 20.2469 8.83608C19.1214 7.65205 17.6594 7 16.1302 7C13.5191 7 11.2872 8.89638 10.4211 11.5525H8.32226C7.88974 11.5525 7.53906 11.9031 7.53906 12.3357C7.53906 12.7682 7.88974 13.1189 8.32226 13.1189H10.0855C10.0537 13.4079 10.0356 13.7014 10.0356 14C10.0356 14.265 10.0494 14.5259 10.0747 14.7832H8.32226C7.88974 14.7832 7.53906 15.1339 7.53906 15.5664C7.53906 15.999 7.88974 16.3496 8.32226 16.3496H10.39C11.2325 19.0571 13.487 21 16.13 21C17.6593 21 19.121 20.3478 20.2465 19.164C20.5444 18.8504 20.5321 18.3547 20.2184 18.0566C19.905 17.7585 19.4091 17.771 19.1114 18.0844Z" fill="var(--color)"/>
							</svg>
						</div>
					</div>
					<?php get_template_part( 'template-parts/ajax/header', 'price', [ 'api_price' => $api_price, 'metal' => $api_metal ] ); ?>
				</div>
				<div class="header_href flex__align">
					<div class="header_href_user">
						<svg width="25" height="24" viewbox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path opacity="0.7" d="M12.9999 12.2157C15.6206 12.2157 17.881 9.67444 17.881 6.35782C17.881 3.99889 17.2976 2.55882 16.4501 1.70521C15.6033 0.852339 14.4085 0.5 12.9999 0.5C11.5914 0.5 10.3965 0.852341 9.54976 1.70521C8.70228 2.55881 8.1189 3.99888 8.1189 6.35781L12.9999 12.2157ZM12.9999 12.2157C10.3791 12.2157 8.11895 9.67446 8.1189 6.35782L12.9999 12.2157ZM24.4247 22.2749L24.4248 22.275C24.5444 22.5469 24.5198 22.8567 24.3594 23.1058C24.1994 23.3543 23.9316 23.4998 23.6418 23.4998H2.35797C2.06806 23.4998 1.80044 23.3543 1.64043 23.1059L1.64039 23.1058C1.47997 22.8567 1.45539 22.5471 1.5751 22.2749L1.1174 22.0736L1.5751 22.2749L4.28991 16.1015C4.28991 16.1015 4.28991 16.1015 4.28991 16.1015C4.36897 15.9217 4.5079 15.773 4.67857 15.6834L4.67864 15.6833L8.76274 13.537C10.0134 14.4544 11.4761 14.942 12.9999 14.942C14.5235 14.942 15.9863 14.4544 17.2369 13.5371L21.3212 15.6833C21.4919 15.773 21.631 15.9219 21.7099 16.1014L21.7099 16.1015L24.4247 22.2749ZM17.3551 13.4487C17.3545 13.4491 17.354 13.4495 17.3535 13.4499L17.3551 13.4487Z" stroke="white"/>
							<path d="M12.9826 23.9998C9.46558 23.9998 5.94858 23.9998 2.43157 23.9998C1.35543 23.9998 0.700125 23.0198 1.13299 22.0338C2.02877 19.9777 2.93658 17.9277 3.83838 15.8776C3.95862 15.607 4.151 15.3966 4.40951 15.2583C5.79828 14.5249 7.19306 13.7974 8.58182 13.058C8.73813 12.9738 8.85837 12.9978 8.99665 13.094C11.0948 14.591 13.3313 14.8616 15.7 13.8395C16.1449 13.6471 16.5477 13.3525 16.9625 13.094C17.1128 12.9978 17.2331 12.9858 17.3894 13.07C18.724 13.7734 20.0527 14.4768 21.3933 15.1742C21.7541 15.3605 22.0126 15.6251 22.1809 16.0038C23.0587 18.0118 23.9424 20.0138 24.8202 22.0218C25.253 23.0138 24.6037 23.9998 23.5216 23.9998C20.0166 23.9998 16.4996 23.9998 12.9826 23.9998ZM23.3893 22.4907C23.3773 22.4547 23.3713 22.4246 23.3653 22.4066C22.5176 20.4767 21.6699 18.5529 20.8222 16.6231C20.7982 16.575 20.7501 16.5269 20.702 16.5028C19.6078 15.9257 18.5136 15.3485 17.4194 14.7714C17.3172 14.7173 17.2451 14.7233 17.1489 14.7774C14.3834 16.3405 11.6119 16.3465 8.84635 14.7894C8.72611 14.7233 8.64194 14.7233 8.5217 14.7834C7.45157 15.3485 6.37543 15.9136 5.3053 16.4788C5.23315 16.5148 5.16101 16.593 5.13095 16.6651C4.30731 18.5228 3.49569 20.3805 2.68408 22.2322C2.648 22.3104 2.61794 22.3946 2.57586 22.4907C9.51969 22.4907 16.4455 22.4907 23.3893 22.4907Z" fill="#D2D1CF"/>
							<path d="M7.5838 6.2464C7.61987 5.26644 7.71607 4.30453 8.01666 3.37267C8.3353 2.36266 8.87037 1.49694 9.75413 0.883715C10.4275 0.414781 11.185 0.16829 11.9906 0.0720981C12.9585 -0.0481414 13.9204 -0.0180815 14.8643 0.252457C16.3373 0.673295 17.3052 1.6292 17.8463 3.04803C18.2911 4.21435 18.3934 5.43478 18.3573 6.66723C18.3152 7.91772 17.9785 9.08405 17.3112 10.1482C16.6379 11.2243 15.7361 12.048 14.5216 12.4568C12.7541 13.052 11.1669 12.6672 9.78419 11.4528C8.61185 10.4307 7.97458 9.10208 7.72809 7.58105C7.64392 7.13617 7.62589 6.69128 7.5838 6.2464ZM9.08079 6.23437C9.12287 6.65521 9.14091 7.08206 9.21906 7.5029C9.44752 8.7113 9.99461 9.73935 10.9806 10.4969C12.1589 11.3987 13.5537 11.4528 14.7862 10.6411C15.4775 10.1842 15.9765 9.55899 16.3312 8.81952C16.698 8.04398 16.8603 7.22034 16.8603 6.36062C16.8603 5.42276 16.7761 4.50292 16.4575 3.61315C16.0547 2.50094 15.2852 1.82759 14.1188 1.60515C13.4635 1.4789 12.8022 1.47289 12.1469 1.55706C10.7882 1.7314 9.89241 2.45284 9.46555 3.76345C9.20103 4.56304 9.11686 5.39269 9.08079 6.23437Z" fill="#D2D1CF"/>
						</svg>
						<div class="header_href_user_wrapper">
							<?php if ( is_user_logged_in() ) {
								$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
								$myaccount_title = get_the_title( $myaccount_page_id ); ?>
								<a href="<?php echo get_permalink( $myaccount_page_id ); ?>" title="<?php echo $myaccount_title; ?>"><?php echo $myaccount_title; ?></a>
								<a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
							<?php }
							else {
								get_template_part( 'ajax', 'auth' ); ?>
								<a class="modal-link" data-modal-name="register">Register</a>
								<a class="modal-link" data-modal-name="login">Login</a>
							<?php } ?>
						</div>
					</div>
					<?php suissevault_header_cart_link(); ?>
				</div>
			</div>
		</div>
	</div>
	<svg class="mask">
		<defs>
			<clippath id="logo_mask">
				<path d="M20.2495 88.0968C21.7015 89.7347 22.4275 91.7432 22.4275 94.1221C22.4275 97.7025 21.4945 100.383 19.6286 102.163C17.7626 103.944 14.9584 104.834 11.216 104.834C7.13309 104.834 4.24266 104.036 2.54469 102.44C0.846733 100.844 -0.00149798 98.241 1.98583e-06 94.6306V93.2379H7.21559V94.2999C7.18259 96.0233 7.49908 97.3148 8.16507 98.1743C8.83105 99.0338 9.84803 99.4643 11.216 99.4658C12.551 99.4658 13.5469 99.078 14.2039 98.3025C14.8609 97.5271 15.1902 96.3533 15.1917 94.7814C15.1994 94.2237 15.096 93.67 14.8873 93.1528C14.6787 92.6355 14.3692 92.165 13.9767 91.7687C13.1847 90.9257 11.792 90.031 9.79853 89.0845C6.32311 87.4435 3.89241 85.8318 2.50645 84.2494C1.12048 82.6669 0.428242 80.7169 0.429742 78.3995C0.429742 74.9391 1.36272 72.3479 3.22868 70.6259C5.09464 68.9039 7.90107 68.043 11.648 68.043C15.4954 68.043 18.2126 68.8447 19.7996 70.4482C21.286 71.9691 22.021 74.4171 22.0045 77.792V79.6482H14.7867V78.5862C14.8212 76.6933 14.5849 75.3598 14.0779 74.5858C13.5709 73.8118 12.6852 73.4233 11.4207 73.4203C10.1698 73.4203 9.23229 73.7788 8.60831 74.4958C7.98432 75.2128 7.67233 76.286 7.67233 77.7155C7.65345 78.7787 8.05348 79.8067 8.78605 80.5774C9.51354 81.3694 10.7968 82.1944 12.6357 83.0524C16.2656 84.7788 18.8036 86.4603 20.2495 88.0968ZM38.5934 74.5318V96.3563C38.5934 97.8353 38.3646 98.8658 37.9071 99.4478C37.4497 100.03 36.6374 100.321 35.4704 100.323C34.3035 100.323 33.4912 100.031 33.0338 99.4478C32.5763 98.8643 32.3513 97.8338 32.3588 96.3563V74.5318H26.3244V95.9468C26.3244 98.8868 27.0879 101.088 28.6149 102.55C30.1418 104.013 32.4308 104.745 35.4817 104.746C38.5341 104.746 40.8231 104.014 42.3485 102.55C43.874 101.086 44.6375 98.8853 44.639 95.9468V74.5318H38.6001H38.5934ZM48.9904 74.5318V104.303H55.0877V74.5318H48.9904ZM68.9407 86.6005C67.4092 85.8836 66.3405 85.1943 65.7345 84.5328C65.1236 83.8907 64.7898 83.0341 64.8053 82.1479C64.8053 80.9479 65.0655 80.0517 65.586 79.4592C66.108 78.8607 66.8865 78.5592 67.9282 78.5592C68.9699 78.5592 69.7282 78.8832 70.1444 79.529C70.5606 80.1747 70.7631 81.2884 70.7339 82.8634V83.7499H76.748V82.2087C76.7615 79.3962 76.1495 77.357 74.912 76.091C73.5906 74.7546 71.3264 74.0863 68.1195 74.0863C64.9965 74.0863 62.6581 74.8033 61.1041 76.2373C59.5501 77.6712 58.7724 79.8305 58.7709 82.7149C58.7709 84.6558 59.3476 86.2811 60.5011 87.5905C61.6546 88.9 63.6796 90.2432 66.576 91.6202C68.2364 92.4077 69.3967 93.1532 70.0567 93.8566C70.3839 94.1868 70.6419 94.579 70.8158 95.0101C70.9896 95.4413 71.0758 95.9028 71.0691 96.3676C71.0691 97.6741 70.7954 98.649 70.2479 99.2925C69.7004 99.936 68.8702 100.26 67.7572 100.264C66.6187 100.264 65.7713 99.9053 65.2148 99.1868C64.6583 98.4683 64.395 97.3928 64.425 95.9603V95.0604H58.4199V96.2213C58.4199 99.2318 59.1264 101.401 60.5394 102.73C61.9523 104.059 64.3613 104.725 67.7662 104.726C70.8891 104.726 73.2276 103.984 74.7815 102.499C76.3355 101.014 77.1125 98.781 77.1125 95.8006C77.1125 93.8161 76.508 92.1422 75.299 90.7787C74.0901 89.4152 71.9729 88.0225 68.9474 86.6005H68.9407ZM90.7494 86.6005C89.215 85.8836 88.1455 85.1943 87.541 84.5328C86.9309 83.8904 86.598 83.0337 86.614 82.1479C86.614 80.9479 86.8743 80.0517 87.3948 79.4592C87.9152 78.8667 88.6952 78.5667 89.7347 78.5592C90.7847 78.5592 91.5234 78.8825 91.9509 79.529C92.3784 80.1754 92.5756 81.2869 92.5426 82.8634V83.7499H98.5545V82.2087C98.5695 79.3962 97.9583 77.357 96.7208 76.091C95.3978 74.7546 93.1329 74.0863 89.926 74.0863C86.803 74.0863 84.4646 74.8033 82.9106 76.2373C81.3566 77.6712 80.5797 79.8305 80.5797 82.7149C80.5797 84.6558 81.1564 86.2811 82.3099 87.5905C83.4633 88.9 85.4883 90.2432 88.3847 91.6202C90.0452 92.4077 91.2062 93.1532 91.8677 93.8566C92.1949 94.1868 92.453 94.579 92.6268 95.0101C92.8006 95.4413 92.8868 95.9028 92.8801 96.3676C92.8801 97.6741 92.6056 98.649 92.0567 99.2925C91.5077 99.9405 90.6797 100.264 89.566 100.264C88.4522 100.264 87.5793 99.9045 87.0258 99.1868C86.4723 98.469 86.2045 97.3868 86.2338 95.9603V95.0604H80.2264V96.2213C80.2264 99.2318 80.9337 101.401 82.3481 102.73C83.7626 104.059 86.1708 104.725 89.5727 104.726C92.6956 104.726 95.0348 103.984 96.5903 102.499C98.1458 101.014 98.9228 98.781 98.9213 95.8006C98.9213 93.8161 98.316 92.1422 97.1055 90.7787C95.8951 89.4152 93.7786 88.0225 90.7562 86.6005H90.7494ZM108.454 91.2624H116.934V86.8323H108.461V78.9732H117.236V74.5318H102.373V104.303H117.418V99.8708H108.461L108.454 91.2624ZM142.159 68.574H138.664L133.906 96.2753L128.922 68.574H121.655L129.372 104.303H137.956L145.653 68.574H142.159ZM156.925 74.5318L163.655 104.303H157.769L156.608 97.8728H150.11L148.908 104.31H143.02L149.77 74.5386H156.923L156.925 74.5318ZM155.8 93.4314L153.402 80.0982L150.927 93.4314H155.8ZM178.05 74.5318V96.3563C178.05 97.8353 177.825 98.8658 177.375 99.4478C176.925 100.03 176.112 100.321 174.938 100.323C173.77 100.323 172.957 100.031 172.501 99.4478C172.045 98.8643 171.82 97.8338 171.826 96.3563V74.5318H165.776V95.9468C165.776 98.8868 166.54 101.088 168.067 102.55C169.594 104.013 171.883 104.745 174.934 104.746C177.987 104.746 180.277 104.014 181.803 102.55C183.328 101.086 184.091 98.8853 184.091 95.9468V74.5318H178.056H178.05ZM194.492 74.5318H188.395V104.303H202.237V99.8708H194.499L194.492 74.5318ZM201.089 74.5318V78.9732H207.504V104.303H213.601V78.9732H220V74.5318H201.089Z" fill="white"/>
				<path d="M99.6345 27.6744L110.052 50.6981C109.172 52.3617 107.994 53.849 106.576 55.0855C103.192 58.0944 98.8688 59.5944 93.6069 59.5854C90.7792 59.5527 87.9772 59.0446 85.3181 58.0824C82.4367 57.079 80.7867 56.5772 80.3682 56.5772C79.3662 56.5772 78.6913 56.884 78.3433 57.4974C77.9985 58.1051 77.7653 58.7695 77.6548 59.4594H75.7761L73.2291 41.2506H75.1911C76.6355 45.0935 78.3313 48.1564 80.2782 50.4394C83.6696 54.4323 87.8845 56.428 92.9229 56.4265C95.5197 56.4741 98.0407 55.5505 99.9923 53.8368C101.981 52.1118 102.975 49.7036 102.973 46.6122C102.973 43.8298 101.974 41.4073 99.9743 39.3449C98.6678 38.0369 95.9161 36.0742 91.7192 33.4567L84.4249 28.9051C82.2289 27.5131 80.477 26.1069 79.169 24.6864C76.739 21.9835 75.5241 19.0046 75.5241 15.7496C75.5241 11.4342 76.9573 7.84257 79.8237 4.97464C81.9102 2.88968 84.4886 1.56371 87.559 0.996727L89.134 4.48865C87.8928 4.81939 86.7337 5.40393 85.7298 6.20536C83.9884 7.58233 83.1184 9.49628 83.1199 11.9472C83.1199 14.1477 83.7866 16.0271 85.1201 17.5856C86.4551 19.1711 88.5273 20.8278 91.3367 22.5557L98.847 27.1906L99.6345 27.6744ZM108.349 15.8284C107.021 12.8735 106.114 10.7608 105.628 9.49028C105.142 8.21981 104.899 7.23134 104.897 6.52485C104.897 5.13888 105.579 4.22015 106.942 3.76866C107.721 3.51217 109.18 3.37042 111.319 3.34342V0H91.8992L96.7748 10.8583C97.0133 11.3622 97.2586 11.8955 97.5106 12.4625L118.66 59.4864H119.947L123.684 49.9489L121.74 45.5997L108.349 15.8284ZM129.278 0V3.34342H146.775V0H129.278Z" fill="white"/>
			</clippath>
		</defs>
	</svg>
</div>
<!-- Header. -->

<!-- Burger. -->
<div class="burger_wrapper">
	<div class="burger_net flex__align">
		<?php wp_nav_menu( [
			'theme_location'  => 'primary',
			'menu_class'      => 'nav',
			'container'       => 'div',
			'container_class' => 'burger_nav'
		] ); ?>
		<?php $contacts = get_field( 'contacts', 'options' ); ?>
		<div class="burger_bottom flex__center">
			<p><?php echo "$contacts[phone]"; ?></p>
			<a class="hover__line-active" href="mailto:<?php echo "$contacts[email]"; ?>"><?php echo "$contacts[email]"; ?></a>
			<?php get_template_part( '`template-parts/social`', 'links' ); ?>
		</div>
	</div>
</div>
<!-- Burger. -->