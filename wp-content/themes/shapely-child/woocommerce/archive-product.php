<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$term = get_queried_object();
$child_cats = get_terms( $term->taxonomy, array(
'parent'    => $term->term_id,
'hide_empty' => false_
) );

get_header( 'shop' ); ?>
<?php if(!$child_cats) : ?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php //woocommerce_page_title(); ?></h1>

		<?php endif; ?>
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			//do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				//do_action( 'woocommerce_before_shop_loop' );
			?>

			<div class="subcat_products">

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php else : ?>

	<ul class="secondary-nav list-inline">
		<?php foreach ($child_cats as $cat) : ?>
			<li>
				<?php 
					
					$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
					$image = wp_get_attachment_url( $thumbnail_id );
					if (!$image) $image = '/wp-content/themes/shapely-child/images/no-image.png';
				?>
				<a href="/idc2/?product_cat=<?php echo $cat->slug; ?>">
					<img src="<?php echo $image; ?>">
					<h5><?php echo $cat->name; ?></h5>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php foreach ($child_cats as $cat) : ?>
		<?php 
			//print_r($child_cats);
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
			$image = wp_get_attachment_url( $thumbnail_id );
			if (!$image) $image = '/wp-content/themes/shapely-child/images/no-image.png';
		?>
		<div class="row category">
			<div class="col-md-7 cat_image">
				<img src="<?php echo $image; ?>">
			</div>
			<div class="col-md-5 cat_info">
				<h2><?php echo $cat->name; ?></h2>
				<div class="description">
				<?php echo $cat->description; ?>
				</div>
				<a class="btn btn-lg btn-filled" href="/idc2/?product_cat=<?php echo $cat->slug; ?>">Подробнее</a>
			</div>
		</div>
	<?php endforeach; ?>

<?php endif; ?>

<?php get_footer( 'shop' ); ?>
