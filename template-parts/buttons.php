<?php

extract($args);

if ( empty($buttons) ) return false;

$class ??= 'sp_button';
$button_text_format ??= '%s';

// buttons argument is natively an array of button field arrays, but will also accept a single button's fields not wrapped in outer array
if ( !is_array($buttons) || ( count($buttons) && !is_array( $buttons[0] ) ) ) $buttons = array($buttons);

if ( count($buttons) ) {
	$alternate = '';
?>
		<div class="button_container">
<?php
	foreach ( $buttons as $button ) {
		$href = '';
		if ( !empty( $button['link_type'] ) ) {
			if ( $button['link_type'] === 'page_link' && !empty( $button['page_link'] ) ) {
				$href = $button['page_link'];
			} else if ( $button['link_type'] === 'url' && !empty( $button['url'] ) )  {
				$href = $button['url'];
			}
		}
		
		if ( !empty($href) ) {
?>
			<a href="<?php echo esc_url( $href ); ?>" class="<?php echo $class . $alternate; ?>"><?php printf( $button_text_format, $button['button_text'] ?: __( 'Learn More', SP_TEXT_DOMAIN ) ); ?></a>
<?php
	}
	
		$alternate = !$alternate ? ' alternate' : '';
	}
?>
	</div>
<?php } ?>
