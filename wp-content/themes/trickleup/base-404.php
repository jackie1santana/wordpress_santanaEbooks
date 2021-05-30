<?php get_header( trickleup_template_base() ); ?>

	<?php trickleup_site_breadcrumbs(); ?>

	<div <?php trickleup_content_wrap_class(); ?>>

		<div class="row">

			<div id="primary" <?php trickleup_primary_content_class(); ?>>

				<main id="main" class="site-main" role="main">

					<?php include trickleup_template_path(); ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- .container -->

<?php get_footer( trickleup_template_base() ); ?>
