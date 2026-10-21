<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

?>
<section class="layout_block welcome <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level">
			<div class="column column-title"><div class="layer_2">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
<?php if ( !empty($intro_text) ) { ?>
				<div class="intro_text">
					<?php echo $intro_text; ?>	
				</div>
<?php } ?>
			</div></div>
			
			<div class="column column-content">
<?php if ( !empty($columns) ) { ?>
				<div class="columns columns-<?php echo $columns_per_row; ?> columns-inner">
<?php foreach ( $columns as $column ) : ?>
					<div class="column">
<?php if ( !empty( $column['icon_css_class'] ) ) { ?>
						<i class="icon-<?php echo esc_attr( $column['icon_css_class'] ); ?>"></i>
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
<?php } ?>
		</div>
	</div>
</section>
