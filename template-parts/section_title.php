<?php

global $h1_already_used;

extract($args);

$heading_tag = !$h1_already_used ? 'h1' : 'p';

$animation ??= null;
$pre_title_animation ??= $animation;
$title_animation ??= $animation;

if ( !empty($pre_title) ) { ?>
		<p class="pre_title<?php if ( !empty($pre_title_animation) ) { ?> wow <?php echo esc_attr( $pre_title_animation ); } ?>"><?php echo $pre_title; ?></p>
<?php } ?>
		
<?php
if ( !empty($title) ) {
	$h1_already_used = true;
?>
		<<?php echo $heading_tag; ?> class="section_title<?php if ( !empty($title_animation) ) { ?> wow <?php echo esc_attr( $title_animation ); } ?>"><?php echo $title; ?></<?php echo $heading_tag; ?>>
<?php } ?>
