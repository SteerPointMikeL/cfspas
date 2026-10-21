<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '2';

?>
<section class="layout_block multi_column_alternate <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column <?php echo esc_attr( $column['color_scheme'] ); ?>">
				<?php echo wp_get_attachment_image( $column['background'], 'medium', null, array('class' => 'background') ); ?>
				
				<div class="overlay"></div>
				
				<div class="layer_2">
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
			</div>
<?php endforeach; ?>
		</div>
	</div>
</section>
