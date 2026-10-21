<?php

if ( empty($packages) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

?>
<section class="layout_block package_comparison_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $packages as $package ) : ?>
			<div class="column <?php echo esc_attr( $package['color_scheme'] ); ?>">
<?php if ( !empty( $package['star_count'] ) && $package['star_count'] > 0 ) { ?>
				<p class="star_rating">
<?php for ( $i = 1; $i <= $package['star_count']; $i++ ) { ?>
					<i class="icon-star"></i>
<?php } ?>
				</p>
<?php } ?>
				
<?php if ( !empty( $package['pre_title'] ) ) { ?>
				<p class="pre_title"><?php echo $package['pre_title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $package['title'] ) ) { ?>
				<p class="title">
<?php if ( !empty( $package['icon_css_class'] ) ) { ?>
					<i class="icon-<?php echo esc_attr( $package['icon_css_class'] ); ?>"></i>
<?php } ?>
					
					<?php echo $package['title']; ?>
				</p>
<?php } ?>
				
<?php if ( !empty( $package['content'] ) ) { ?>
				<div class="content">
					
					<?php echo $package['content']; ?>
					
				</div>
<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
	</div>
</section>
