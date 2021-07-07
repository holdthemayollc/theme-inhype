<?php
/**
 * The template for displaying search forms in InHype search block
 *
 * @package InHype
 */
?>
<form method="get" role="search" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" aria-label="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" class="field" name="s" value="" placeholder="<?php echo esc_attr__('Type keyword(s) here&hellip;', 'inhype' ); ?>" /><input type="submit" class="submit btn" value="<?php echo esc_attr__( 'Search', 'inhype' ); ?>" />
</form>
