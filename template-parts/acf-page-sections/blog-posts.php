<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($content) ) $content = '';

?>
<section class="layout_block blog_posts <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level">
			<div class="column column-1 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
				<?php get_template_part('template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div>
			
			<div class="column column-2 column-posts">
<?php
$blog_posts = new WP_Query( array('posts_per_page' => 3) );
if ( $blog_posts->have_posts() ) :
?>
				<div class="columns columns-3 columns-inner">
<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
					<div class="column">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="post_thumbnail_container">
								<?php the_post_thumbnail( 'medium' ); ?>
							</div>
							
							<p class="title"><?php the_title(); ?></p>
							
							<?php sp_the_excerpt_shorter(); ?>
							
							<a href="<?php the_permalink(); ?>" class="read_more">Read More <i class="icon-arrow-right"></i></a>
						</article>
					</div>
<?php endwhile; ?>
				</div>
<?php endif; ?>
			</div>
		</div>
	</div>
</section>
