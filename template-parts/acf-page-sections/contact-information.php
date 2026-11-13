<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

$social_media_links = get_field( 'social_media_links', 'option');

?>
<section class="layout_block contact_information <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( implode( ' ', $appearance_modifiers_more ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
				<div class="title_container">
<?php if ( !empty( $column['icon_css_class'] ) ) { ?>
					<p><i class="icon-<?php echo esc_attr( $column['icon_css_class'] ); ?>"></i></p>
<?php } ?>
					
<?php if ( !empty( $column['title'] ) ) { ?>
					<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
				</div>
				
<?php if ( !empty( $column['content'] ) ) { ?>
				<div class="content">
					
					<?php echo $column['content']; ?>
					
				</div>
<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
		
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
