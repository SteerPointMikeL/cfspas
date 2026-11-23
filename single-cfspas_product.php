<?php /* Template Name: Has Page Sections */ ?>

<?php get_header(); ?>

<?php get_template_part('template-parts/hero'); ?>

<?php if ( have_rows('header') ) : the_row(); ?>
<section id="product_header"<?php if ( get_sub_field('appearance_modifiers') ) { ?> class="<?php echo esc_attr( implode( ' ', get_sub_field('appearance_modifiers') ) ); ?>"<?php } ?>>
	<div class="wrap">
		<div class="columns columns-2 columns-top_level">
			<div class="column column-1 column-image wow fadeInLeft">
				<?php echo wp_get_attachment_image( get_sub_field('image'), 'medium_large', null, array('class' => 'image') ); ?>
			</div>
			
			<div class="column column-2 column-content wow fadeInRight"><div class="layer_2">
<?php
$brand_image_id = sp_get_product_brand_image_id();
if ( $brand_image_id ) {
?>
				<?php echo wp_get_attachment_image( $brand_image_id, 'medium', null, array('class' => 'brand_image') ); ?>
<?php } ?>
				
				<?php
				get_template_part( 'template-parts/section_title', null, array(
					'pre_title' => get_sub_field('pre_title') ?: get_sub_field('model_year'),
					'title'     => get_sub_field('alternate_product_title') ?: get_the_title(),
				) );
				?>
				
<?php if ( get_sub_field('secondary_title') ) { ?>
				<p class="secondary_title">
					<i class="icon-map-pin"></i>
					
					<?php the_sub_field('secondary_title'); ?>
				</p>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => get_sub_field('buttons') ) ); ?>
			</div></div>
		</div>
	</div>	
</section>
<?php endif; ?>

<?php if ( have_rows('specifications_section') ) : the_row(); ?>
<section id="product_specifications"<?php if ( get_sub_field('appearance_modifiers') ) { ?> class="<?php echo esc_attr( implode( ' ', get_sub_field('appearance_modifiers') ) ); ?>"<?php } ?>>
	<div class="wrap">
		<div class="columns columns-2 columns-rtl columns-top_level">
			<div class="column column-1 column-image wow fadeInRight">
				<?php echo wp_get_attachment_image( get_sub_field('image'), 'medium_large', null, array('class' => 'image') ); ?>
			</div>
			
			<div class="column column-2 column-content wow fadeInLeft">
				<?php
				get_template_part( 'template-parts/section_title', null, array(
					'pre_title' => get_sub_field('pre_title') ?: __( 'Specifications', SP_TEXT_DOMAIN ),
					'title'     => get_sub_field('title'),
				) );
				?>
				
<?php if ( have_rows('specifications') ) : ?>
				<ul class="specifications_list">
<?php while( have_rows('specifications') ) : the_row(); ?>
					<li>
						<p class="title"><?php the_sub_field('name'); ?></p>
						
						<p class="value"><?php the_sub_field('value'); ?></p>
					</li>
<?php endwhile; ?>
				</ul>
<?php endif; ?>
				
<?php if ( get_sub_field('after_specifications_text') ) { ?>
				<div class="after_specifications_text">
					<?php the_sub_field('after_specifications_text'); ?>
				</div>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => get_sub_field('buttons') ) ); ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php sp_load_acf_page_sections( get_field('page_sections') ); ?>

<?php get_footer(); ?>