<?php
/**
 * The template for displaying search forms in InHype
 *
 * @package InHype
 */
?>
<form method="get" role="search" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" aria-label="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr__('Type keyword(s) here &hellip;', 'inhype' ); ?>" /><input type="submit" class="submit btn" id="searchsubmit" value="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" />
</form>
