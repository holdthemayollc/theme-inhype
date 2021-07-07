<?php
/**
 * The template for displaying fullscreen search form
 *
 * @package InHype
 */
?>
<form method="get" role="search" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" aria-label="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr__('Type keyword(s) here and hit Enter &hellip;', 'inhype' ); ?>" /><input type="submit" class="submit btn" value="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" />
</form>
