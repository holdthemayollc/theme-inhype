<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package InHype
 */

get_header(); ?>
<div class="content-block" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-404">
					<h1><?php esc_html_e("404", 'inhype'); ?></h1>
					<?php
					// Site 404 Banner
					inhype_banner_display('404');
					?>
					<h3><?php esc_html_e( 'Looks like you\'re lost.', 'inhype' ); ?></h3>
					<p><?php esc_html_e( 'We can’t seem to find the page you’re looking for.', 'inhype' ); ?></p>
					<div class="search-form">
						<?php get_search_form(true); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
