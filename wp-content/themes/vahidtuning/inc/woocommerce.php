<?php
/** Integration details; core cart/checkout/order logic remains in WooCommerce. */
defined( 'ABSPATH' ) || exit;

// WooCommerce does not ship a Toman denomination in every installation.
add_filter( 'woocommerce_currencies', function( $currencies ) {
    $currencies['IRT'] = 'تومان ایران';
    return $currencies;
} );
add_filter( 'woocommerce_currency_symbol', function( $symbol, $currency ) {
    return 'IRT' === $currency ? 'تومان' : $symbol;
}, 10, 2 );

function vt_single_product_art() {
    global $product;
    if ( ! $product instanceof WC_Product ) { return; }
    echo '<div class="woocommerce-product-gallery vt-single-placeholder"><div class="woocommerce-product-gallery__wrapper"><img src="' . esc_url( vt_product_art( $product ) ) . '" alt="' . esc_attr( $product->get_name() ) . '" width="640" height="520"></div></div>';
}
add_action( 'wp', function() {
    if ( ! function_exists( 'is_product' ) || ! is_product() ) { return; }
    $product = wc_get_product( get_queried_object_id() );
    if ( $product && ! $product->get_image_id() ) {
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        add_action( 'woocommerce_before_single_product_summary', 'vt_single_product_art', 20 );
    }
} );

// Untranslated WooCommerce string fallbacks for important storefront actions.
add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {
    if ( $product->is_type( 'variable' ) ) { return 'انتخاب گزینه‌ها'; }
    if ( ! $product->is_purchasable() ) { return 'مشاهده محصول'; }
    return 'افزودن به سبد';
}, 10, 2 );
