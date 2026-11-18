<?php
/**
 * Product tile: uses WooCommerce's real catalog state and add-to-cart.
 * @package VahidTuning
 */
defined( 'ABSPATH' ) || exit;
global $product;
if ( ! $product || ! $product->is_visible() ) { return; }
$terms = wc_get_product_category_list( $product->get_id(), ', ' );
?>
<li <?php wc_product_class( 'vt-product-card', $product ); ?>>
    <a class="vt-product-image" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
        <?php if ( $product->is_on_sale() ) : ?><span class="vt-product-badge">پیشنهاد ویژه</span><?php endif; ?>
        <?php if ( $product->get_image_id() ) : ?>
            <?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
        <?php else : ?>
            <img loading="lazy" class="vt-product-placeholder" src="<?php echo esc_url( vt_product_art( $product ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" width="520" height="470">
        <?php endif; ?>
    </a>
    <div class="vt-product-body">
        <span class="vt-product-category"><?php echo wp_kses_post( $terms ? $terms : 'تجهیزات موتور تریل' ); ?></span>
        <h2 class="vt-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="vt-product-bottom">
            <span class="vt-product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
            <span class="vt-product-add"><?php woocommerce_template_loop_add_to_cart(); ?></span>
        </div>
    </div>
</li>
