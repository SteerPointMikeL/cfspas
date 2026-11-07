<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

?>
<section class="layout_block the_benefits_style_b <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="overlay"></div>
	
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
	
<?php if ( !empty($columns) ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
<?php if ( !empty( $column['icon_css_class'] ) ) { ?>
				<p><i class="icon-<?php echo esc_attr( $column['icon_css_class'] ); ?>"></i></p>
<?php } ?>
				
<?php if ( !empty( $column['title'] ) ) { ?>
				<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $column['content'] ) ) { ?>
				<div class="content">
					
					<?php echo $column['content']; ?>
					
				</div>
<?php } ?>				
			</div>
<?php endforeach; ?>
		</div>
<?php } ?>
	</div>
</section>
