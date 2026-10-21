<?php if ( !defined('ABSPATH') ) exit; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="profile" href="http://gmpg.org/xfn/11" />

<!--wp_head()-->
<?php wp_head(); ?>
<!--end wp_head()-->

</head>

<body <?php body_class(); ?>>
	
<?php wp_body_open(); ?>

<nav id="responsive_menu">
	<div class="overlay"></div>
	
	<div class="menu_container">
		<div class="top_bar">
			<a href="#" class="close">Close <i class="icon-close-button"></i></a>
		</div>
		
		<ul class="menu">
<?php if ( has_nav_menu('mobile') ) { ?>
			<?php wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
<?php } else if ( has_nav_menu('header') ) { ?>
			<?php wp_nav_menu( array( 'theme_location' => 'header', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
<?php } else { ?>
			<?php wp_list_pages( array( 'title_li' => false, 'depth' => 1 ) ); ?>
<?php } ?>
		</ul>
		
		<p><a href="/contact-us/" class="sp_button">Contact Us</a></p>
	</div>
</nav>

<div id="cookie_notice" class="hidden">
	<div class="wrap">
		<p>We use cookies to improve your experience. By clicking "Accept," you consent to our use of cookies. <a href="/legal-documents#privacy-policy">Privacy Policy</a></p>
		
		<a href="#" class="sp_button dismiss">Accept</a>
	</div>
</div>

<div class="header_container">
	<header id="upper">
		<div class="wrap">
			<ul class="social_media">
				<li><a href="https://www.facebook.com/carefreespasindy" title="Facebook" target="_blank" ><i class="icon-facebook"></i></a></li>
				<li><a href="https://x.com/CarefreeSpasInc" title="X (Twitter)" target="_blank" ><i class="icon-x"></i></a></li>
			</ul>
		</div>
	</header>
	
	<header id="header">
		<div class="wrap">
			<a id="sp_responsive_menu_button" href="#" role="button" aria-label="<?php _e( 'Menu', SP_TEXT_DOMAIN ); ?>"><i class="icon-menu"></i></a>
			
			<div class="logo" itemprop="logo"><a itemprop="url" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
			
			<nav class="nav">
				<?php wp_nav_menu( array( 'theme_location' => 'header', 'container' => false, 'menu_class' => 'menu touchscreen_compatible', 'fallback_cb' => false ) ); ?>
			</nav>
			
			<div class="button_container">
				<a href="tel:+1-317-849-7727" class="sp_button">Call Now</a>
			</div>
		</div>
	</header>
</div>
