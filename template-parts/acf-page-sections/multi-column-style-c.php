<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '2';

?>
<section class="layout_block multi_column_style_c <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
		<div class="intro_text_outer">
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>	
			</div>
<?php } ?>
			
			<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $button ) ) ); ?>
		</div>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
<?php if ( !empty( $column['image'] ) ) { ?>
				<div class="image_container">
					<?php echo wp_get_attachment_image( $column['image'], 'medium_large', null, array('class' => 'image') ); ?>
					
					<div class="overlay"></div>
					
<?php
$href = '';
if ( !empty( $column['button']['link_type'] ) ) {
	if ( $column['button']['link_type'] === 'page_link' && !empty( $column['button']['page_link'] ) ) {
		$href = $column['button']['page_link'];
	} else if ( $column['button']['link_type'] === 'url' && !empty( $column['button']['url'] ) )  {
		$href = $column['button']['url'];
	}
}

if ( !empty($href) ) {
?>
					<a href="<?php echo esc_url( $href ); ?>" class="full_coverage_link"><?php echo $button['button_text'] ?: '&nbsp;' ?></a>
<?php } ?>
				</div>
<?php } ?>
				
<?php if ( !empty( $column['title'] ) ) { ?>
				<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $column['content'] ) ) { ?>
				<div class="content">
					
					<?php echo $column['content']; ?>
					
				</div>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $column['button'] ) ) ); ?>
			</div>
<?php endforeach; ?>
		</div>
	</div>
</section>
