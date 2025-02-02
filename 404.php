<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Membership
 */

get_header();
?>

<div class="membership-header">
  <div class="container">

  	<h1 class="text-center mb-5 header-white"><span class="header-yellow">Oops!</span> That page can't be found.</h1>
    
  </div>
</div>

<div class="pricing-section" >
    <div class="container">
	<div class="memberpress-products-wrapper">
	<main id="primary" class="site-main">

		<section class="error-404 not-found">

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'membership' ); ?></p>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
	</div>
	</div>
</div>

<?php
get_footer();
