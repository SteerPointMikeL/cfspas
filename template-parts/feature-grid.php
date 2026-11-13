<?php
/**
 * Grid of product feature cards (cfspas_feature posts).
 *
 * $args:
 *   features - array of feature post objects or IDs
 *   columns  - columns per row (default 3)
 */

$features = array_filter( array_map( 'get_post', (array) $args['features'] ) );
$columns = min( 6, max( 1, intval( $args['columns'] ?? 3 ) ?: 3 ) );

if ( empty( $features ) ) return;

?>
<div class="columns columns-<?php echo $columns; ?> columns-features">
<?php foreach ( $features as $feature ) { ?>
	<div class="column">
		<div class="feature_card">
<?php if ( has_post_thumbnail( $feature ) ) { ?>
			<div class="image_container">
				<?php echo get_the_post_thumbnail( $feature, 'sp_medium_less_large', array( 'class' => 'image', 'alt' => '' ) ); ?>
			</div>
<?php } ?>

			<p class="title"><?php echo get_the_title( $feature ); ?></p>

			<div class="description">
				<?php echo apply_filters( 'the_content', $feature->post_content ); ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
