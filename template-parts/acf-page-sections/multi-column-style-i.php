<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '2';

?>
<section class="layout_block multi_column_style_i <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( implode( ' ', $appearance_modifiers_more ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap"><div class="layer_2">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $i => $column ) : ?>
			<div class="column wow fadeInUpSmall" data-wow-delay="<?php echo $i * 150 % 300; ?>ms">
				<?php echo wp_get_attachment_image( $column['image'], 'medium_large', null, array('class' => 'image') ); ?>
				
				<div class="content_container">
<?php if ( !empty( $column['title'] ) ) { ?>
					<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
					
<?php if ( !empty( $column['content'] ) ) { ?>
					<div class="content">
						
						<?php echo $column['content']; ?>
						
					</div>
<?php } ?>
				</div>
			</div>
<?php endforeach; ?>
		</div>
	</div>
</section>
