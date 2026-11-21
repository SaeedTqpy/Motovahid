<?php
/**
 * Product tile: uses WooCommerce's real catalog state and add-to-cart.
 * @package MotoVahid
 */
defined( 'ABSPATH' ) || exit;
global $product;
if ( ! $product || ! $product->is_visible() ) { return; }
$terms = wc_get_product_category_list( $product->get_id(), ', ' );
$badge = '';
if ( ! $product->is_in_stock() ) {
    $badge = 'ناموجود';
} elseif ( $product->is_on_sale() ) {
    $badge = 'پیشنهاد ویژه';
    $discount = vt_product_discount_percent( $product );
    if ( $discount > 0 ) {
        $badge = vt_format_number( $discount ) . '٪ تخفیف';
    }
}
?>
<li <?php wc_product_class( 'vt-product-card', $product ); ?>>
    <a class="vt-product-image" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
        <?php if ( $badge ) : ?><span class="vt-product-badge<?php if ( ! $product->is_in_stock() ) : ?> vt-product-badge-muted<?php endif; ?>"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
        <?php if ( $product->get_image_id() ) : ?>
            <?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
        <?php else : ?>
            <img loading="lazy" class="vt-product-placeholder" src="<?php echo esc_url( vt_product_art( $product ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" width="520" height="470">
        <?php endif; ?>
    </a>
    <div class="vt-product-body">
        <span class="vt-product-category"><?php echo wp_kses_post( $terms ? $terms : 'تجهیزات موتور تریل' ); ?></span>
        <h2 class="vt-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( wc_review_ratings_enabled() && $product->get_rating_count() ) : ?>
            <div class="vt-product-rating">
                <?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ) ); ?>
                <small>(<?php echo esc_html( vt_format_number( $product->get_rating_count() ) ); ?>)</small>
            </div>
        <?php endif; ?>
        <div class="vt-product-bottom">
            <span class="vt-product-price"><?php echo wp_kses_post( vt_persian_price_html( $product->get_price_html() ) ); ?></span>
            <span class="vt-product-add"><?php woocommerce_template_loop_add_to_cart(); ?></span>
        </div>
    </div>
</li>
