<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Jekkilekki
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
