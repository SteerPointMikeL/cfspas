<?php /* Template Name: Home */ ?>

<?php global $h1_already_used; ?>

<?php get_header(); ?> 

<?php if ( have_rows('hero_home') ) : the_row(); ?>
<section id="hero_home">
<?php if ( !get_sub_field('media_type') || get_sub_field('media_type') == 'image' ) { ?>
	<?php echo wp_get_attachment_image( get_sub_field('image'), 'full', null, array('class' => 'background', 'loading' => 'eager', 'fetchpriority' => 'high') ); ?>
<?php } else if ( get_sub_field('media_type') == 'video' && get_sub_field('video') ) { ?>
	<div class="video_container">
		<video muted autoplay loop playsinline webkit-playsinline>
			<source src="<?php echo get_sub_field('video'); ?>" type="video/mp4" />
		</video>
	</div>
<?php } ?>
	
	<div class="overlay"></div>
	
	<div class="wrap">
<?php if ( get_sub_field('pre_title') ) { ?>
		<p class="pre_title"><?php the_sub_field('pre_title'); ?></p>
<?php } ?>
		
<?php
if ( get_sub_field('title') ) {
	$h1_already_used = true;
?>
		<h1 class="title"><?php the_sub_field('title'); ?></h1>
<?php } ?>
		
		<div class="content">
			
			<?php the_sub_field('content'); ?>
			
<?php if ( have_rows('calls_to_action') ) : ?>
			<div class="columns columns-3 columns-top_level columns-calls_to_action">
<?php while ( have_rows('calls_to_action') ) : the_row(); ?>
				<div class="column">
					<?php echo wp_get_attachment_image( get_sub_field('image'), 'medium_less_large', null, array('class' => 'image') ); ?>
					
<?php if ( get_sub_field('title_image') ) { ?>
					<p class="title"><?php echo wp_get_attachment_image( get_sub_field('title_image'), 'medium', null, array('alt' => get_sub_field('title'), 'class' => 'title_image') ); ?></p>
<?php } else if ( get_sub_field('title') ) { ?>
					<p class="title"><?php the_sub_field('title'); ?></p>
<?php } ?>
					
					<?php the_sub_field('content'); ?>
					
					<?php get_template_part('template-parts/buttons', null, array( 'buttons' => array( get_sub_field('button') ) ) ); ?>
				</div>
<?php endwhile ?>
			</div>
<?php endif; reset_rows(); ?>
		</div>
<?php endif; ?>
	</div>
</section>

<?php sp_load_acf_page_sections( get_field('page_sections') ); ?>

<?php get_footer(); ?>