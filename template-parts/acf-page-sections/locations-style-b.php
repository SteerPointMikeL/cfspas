<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

$locations = get_field( 'locations', 'option');
$social_media_links = get_field( 'social_media_links', 'option');

?>
<section class="layout_block locations_style_b <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php if ( !empty($locations) && is_array($locations) && count($locations) ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $locations as $location ) : ?>
			<div class="column">
<?php if ( !empty( $location['title'] ) ) { ?>
				<p class="title"><?php echo $location['title']; ?></p>
<?php } ?>

<?php if ( !empty( $location['contact_information'] ) && is_array( $location['contact_information'] ) && count( $location['contact_information'] ) ) { ?>
				<ul class="contact_information">
<?php foreach ( $location['contact_information'] as $c ) { ?>
					<li>
						<p class="title"><?php echo $c['title']; ?></p>
						
						<div class="content_container">
							<i class="icon-<?php echo esc_attr( $c['icon_css_class'] ); ?>"></i>
							
							<?php echo $c['content']; ?>
						</div>
					</li>
<?php } ?>
				</ul>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $location['button'] ) ) ); ?>
			</div>
<?php endforeach; ?>
		</div>
<?php } ?>
		
<?php if ( !empty($social_media_links) && is_array($social_media_links) && count($social_media_links) ) { ?>
		<div class="social_media">
			<p class="title">Follow Us:</p>
			
			<ul>
<?php foreach ( $social_media_links as $link ) { ?>
				<li><a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" title="<?php echo esc_attr( $link['name'] ); ?>"><i class="icon-<?php echo esc_attr( $link['icon'] ); ?>"></i></a></li>
<?php } ?>
			</ul>
		</div>
<?php } ?>
	</div>
</section>
