<?php

global $h1_already_used;

$heading_tag = !$h1_already_used ? 'h1' : 'h2';

?>

<?php get_header(); ?>

<?php get_template_part('template-parts/hero'); ?>

<main id="main">
	<div class="wrap">
		<div id="content">
<?php if ( is_category() ) { ?>
			<<?php echo $heading_tag; ?> class="page_title"><?php single_cat_title(); ?></<?php echo $heading_tag; ?>>
<?php } else { ?>
			<p class="pre_title">Our Learning Center</p>
			
			<<?php echo $heading_tag; ?> class="page_title">Welcome to Our Blog</<?php echo $heading_tag; ?>>
<?php
}

$h1_already_used = true;
?>
			
			<div class="intro_text">
				<p>Browse information, find the latest news and make the most of your home with the information in our digital learning and resource center.</p>
			</div>
			
<?php if ( have_posts() ) : ?>
			<div class="columns columns-3 columns-post_archive">
<?php $i = 0; while ( have_posts() ) : the_post(); ?>
				<div class="column wow fadeInUpSmall" data-wow-delay="<?php echo $i * 150; ?>ms">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="image_container">
							<?php the_post_thumbnail( 'medium_large', array('class' => 'image') ); ?>
						</div>
						
						<p class="title"><?php the_title(); ?></p>
						
						<p class="postmetadata">
							<?php echo get_the_date('F j, Y'); ?>
						</p>
						
						<p><?php echo sp_get_the_excerpt_force_trim(); ?></p>
						
						<a href="<?php the_permalink(); ?>" class="read_more">Read More <i class="icon-arrow-right"></i></a>
						
						<a href="<?php the_permalink(); ?>" class="full_coverage_link"><?php the_title(); ?></a>
					</article>
				</div>
<?php $i++; endwhile; ?>
			</div>
<?php endif; ?>
			
<?php get_template_part('template-parts/pager'); ?>
			
		</div>
	</div>
</main>

<?php get_template_part('template-parts/newsletter_sign_up'); ?>

<?php get_footer(); ?>