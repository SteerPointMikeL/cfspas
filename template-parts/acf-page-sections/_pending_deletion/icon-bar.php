<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

?>
<section class="layout_block icon_bar <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
<?php if ( !empty( $column['icon_css_class'] ) ) { ?>
				<i class="icon-<?php echo esc_attr( $column['icon_css_class'] ); ?>"></i>	
<?php } ?>
				
				<div class="layer_2">
<?php if ( !empty( $column['title'] ) ) { ?>
					<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
					
					<?php if ( !empty( $column['content'] ) ) echo $column['content']; ?>
					
				</div>
			</div>
<?php endforeach; ?>
		</div>
	</div>
</section>
