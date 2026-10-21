<footer id="footer">
	<div class="wrap">
		<div class="columns columns-3 columns-top_level columns-contact_information">
			<div class="column">
				<div class="title">Jacuzzi&reg; Dealership</div>
				
				<ul class="contact_information">
					<li><i class="icon-map-marker"></i> <a href="https://maps.app.goo.gl/4FKzhDFXNuAMudaY9" target="_blank">9529 Corporation Dr. Indianapolis, IN 46256</a></li>
					<li><i class="icon-phone"></i> <a href="tel:+1-317-849-7727">317-849-7727 EXT #3</a></li>
					<li>
						<i class="icon-clock"></i>
						
						M, T, Th, F: 10 AM - 7 PM<br />
						Wed: 10 AM - 6 PM<br />
						Sat: 10 AM - 5 PM<br />
						*Late Evenings/Sundays Appt. Only
					</li>
				</ul>
				
				<a href="https://cfspas.com/locations/jacuzzi-dealership/" class="link">View Location</a>
			</div>
			
			<div class="column">
				<div class="title">HotSpring Dealership</div>
				
				<ul class="contact_information">
					<li><i class="icon-map-marker"></i> <a href="https://maps.app.goo.gl/sfnnG57sSBo3hxwB9" target="_blank">9133 Pendleton Pike Indianapolis, IN 46236</a></li>
					<li><i class="icon-phone"></i> <a href="tel:+1-317-869-0549">317-869-0549 EXT #2</a></li>
					<li>
						<i class="icon-clock"></i>
						
						M, T, Th, F: 10 AM - 7 PM<br />
						Wed: 10 AM - 6 PM<br />
						Sat: 10 AM - 5 PM<br />
						*Late Evenings/Sundays Appt. Only
					</li>
				</ul>
				
				<a href="/locations/hotspring-dealership/" class="link">View Location</a>
			</div>
			
			<div class="column">
				<div class="title">Caldera Spas and Clearance Center</div>
				
				<ul class="contact_information">
					<li><i class="icon-map-marker"></i> <a href="https://maps.app.goo.gl/4cnkb43qhexRLwcS7" target="_blank">10710 Pendleton Pike Indianapolis, IN 46236</a></li>
					<li><i class="icon-phone"></i> <a href="tel:+1-317-826-8200">317-826-8200 EXT #1</a></li>
					<li>
						<i class="icon-clock"></i>
						
						M, T, Th, F: 10 AM - 7 PM<br />
						Wed: 10 AM - 6 PM<br />
						Sat: 10 AM - 5 PM<br />
						*Late Evenings/Sundays Appt. Only
					</li>
				</ul>
				
				<a href="/locations/sundance-dealership/" class="link">View Location</a>
			</div>
		</div>
		
		<div class="columns columns-4 columns-top_level columns-main_columns">
			<div class="column column-1"><div class="layer_2">
				<p style="margin-bottom: 25px;"><img src="<?php echo get_template_directory_uri(); ?>/images/header-logo.svg" alt="" width="103" height="133" /></p>
				
				<p>Relaxation Made Easy Since 1988.</p>
				
				<ul class="social_media">
					<li><a href="https://www.facebook.com/carefreespasindy" title="Facebook" target="_blank" ><i class="icon-facebook"></i></a></li>
					<li><a href="https://x.com/CarefreeSpasInc" title="X (Twitter)" target="_blank" ><i class="icon-x"></i></a></li>
				</ul>
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

<?php //get_template_part('template-parts/structured_data'); ?>
	
</body>
</html>

<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->