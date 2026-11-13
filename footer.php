<?php

$locations = get_field( 'locations', 'option');
$social_media_links = get_field( 'social_media_links', 'option');

?>
<footer id="footer">
	<div class="wrap">
<?php if ( !empty($locations) && is_array($locations) && count($locations) ) { ?>
		<div class="columns columns-3 columns-top_level columns-contact_information">
<?php foreach ( $locations as $location ) : ?>
			<div class="column">
<?php if ( !empty( $location['title'] ) ) { ?>
				<p class="title"><?php echo $location['title']; ?></p>
<?php } ?>

<?php if ( !empty( $location['contact_information'] ) && is_array( $location['contact_information'] ) && count( $location['contact_information'] ) ) { ?>
				<ul class="contact_information">
<?php foreach ( $location['contact_information'] as $c ) { ?>
					<li><i class="icon-<?php echo esc_attr( $c['icon_css_class'] ); ?>"></i> <?php echo $c['content']; ?></li>
<?php } ?>
				</ul>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $location['button'] ) ) ); ?>
			</div>
<?php endforeach; ?>
		</div>
<?php } ?>
		
		<div class="columns columns-4 columns-top_level columns-main_columns">
			<div class="column column-1"><div class="layer_2">
				<p style="margin-bottom: 25px;"><img src="<?php echo get_template_directory_uri(); ?>/images/header-logo.svg" alt="" width="103" height="133" /></p>
				
				<p>Relaxation Made Easy Since 1988.</p>
				
				
<?php if ( !empty($social_media_links) && is_array($social_media_links) && count($social_media_links) ) { ?>
				<ul class="social_media">
<?php foreach ( $social_media_links as $link ) { ?>
					<li><a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" title="<?php echo esc_attr( $link['name'] ); ?>"><i class="icon-<?php echo esc_attr( $link['icon'] ); ?>"></i></a></li>
<?php } ?>
				</ul>
<?php } ?>
			</div></div>
			
			<div class="column"><div class="layer_2">
				<p class="title"><?php echo wp_get_nav_menu_name('footer-1'); ?></p>
				
				<?php wp_nav_menu( array( 'theme_location' => 'footer-1', 'container' => false, 'menu_class' => 'menu touchscreen_compatible', 'fallback_cb' => false) ); ?>
			</div></div>
			
			<div class="column"><div class="layer_2">
				<p class="title"><?php echo wp_get_nav_menu_name('footer-2'); ?></p>
				
				<?php wp_nav_menu( array( 'theme_location' => 'footer-2', 'container' => false, 'menu_class' => 'menu touchscreen_compatible', 'fallback_cb' => false) ); ?>
			</div></div>
			
			<div class="column"><div class="layer_2">
				<p class="title"><?php echo wp_get_nav_menu_name('footer-3'); ?></p>
				
				<?php wp_nav_menu( array( 'theme_location' => 'footer-3', 'container' => false, 'menu_class' => 'menu touchscreen_compatible', 'fallback_cb' => false) ); ?>
			</div></div>
		</div>
	</div>
</footer>

<div id="sub_footer">
	<div class="wrap">		
		<p class="copyright">
			<?php printf( __('&copy; Copyright %s %s. All Rights Reserved', SP_TEXT_DOMAIN), date( 'Y', current_time('timestamp') ), get_bloginfo('name') ); ?> &bull; Site by <a href="https://www.steerpoint.com<?php /* ?utm_source=clients&utm_medium=referral&utm_campaign=<?php echo SP_TEXT_DOMAIN; */ ?>" target="_blank">SteerPoint</a> |
			<a href="/legal-documents/">Legal</a>
		</p>
	</div>
</div> 

<nav id="mobile_footer">
	<ul>
		<li><a href="tel:+1-317-849-7727"><i class="icon-phone"></i> Call</a></li>
		<li><a href="/contact-us/" class="alternate"><i class="icon-envelope"></i> Contact Us</a></li>
	</ul>
</nav>

<!-- wp_footer() -->
<?php wp_footer(); ?>
<!-- end wp_footer() -->
	
</body>
</html>

<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->