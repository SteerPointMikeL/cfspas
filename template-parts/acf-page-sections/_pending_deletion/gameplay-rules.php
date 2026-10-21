<?php

if ( empty($columns) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

?>
<section class="layout_block gameplay_rules <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
<?php if ( $column['icon_css_class'] ) { ?>
				<div class="icon_row">
					<i class="icon-<?php echo esc_attr( $column['icon_css_class'] ); ?>"></i>
				</div>
<?php } ?>
				
<?php if ( !empty( $column['pre_title'] ) ) { ?>
				<p class="pre_title"><?php echo $column['pre_title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $column['title'] ) ) { ?>
				<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
		
<?php if ( !empty($content) ) { ?>
		<div class="content">
			
			<?php echo $content; ?>
			
		</div>
<?php } ?>
		
		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
		
	</div>
</section>
