<?php
/**
 * Vahid Tuning: bespoke, right-to-left WooCommerce storefront.
 *
 * @package VahidTuning
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'VT_VERSION', '1.0.0' );

function vt_setup() {
    load_theme_textdomain( 'vahidtuning', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
    add_theme_support( 'woocommerce', array( 'thumbnail_image_width' => 520, 'single_image_width' => 900, 'product_grid' => array( 'default_rows' => 3, 'min_rows' => 1, 'max_rows' => 8, 'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 4 ) ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    register_nav_menus( array( 'primary' => 'منوی اصلی', 'footer' => 'منوی پایین صفحه' ) );
}
add_action( 'after_setup_theme', 'vt_setup' );

function vt_enqueue_assets() {
    wp_enqueue_style( 'vt-fonts', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800;900&display=swap', array(), null );
    wp_enqueue_style( 'vt-style', get_stylesheet_uri(), array( 'vt-fonts' ), VT_VERSION );
    wp_enqueue_script( 'vt-storefront', get_template_directory_uri() . '/assets/js/storefront.js', array(), VT_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'vt_enqueue_assets' );

function vt_customize( $customizer ) {
    $customizer->add_section( 'vt_store', array( 'title' => 'تنظیمات فروشگاه وحید تیونینگ', 'priority' => 32 ) );
    $settings = array(
        'vt_hero_title' => array( 'تیتر صفحه نخست', 'برای مسیرهایی که پایان ندارند', 'text' ),
        'vt_hero_description' => array( 'توضیح صفحه نخست', 'تجهیزات تخصصی موتور تریل، اندرو و آفرود؛ انتخاب‌های جسورانه برای ماجراجویی امن‌تر.', 'textarea' ),
        'vt_phone' => array( 'شماره تماس', '', 'text' ),
        'vt_instagram' => array( 'لینک اینستاگرام', '', 'url' ),
        'vt_whatsapp' => array( 'شماره واتساپ با کد کشور (بدون +)', '', 'text' ),
        'vt_address' => array( 'نشانی فروشگاه', '', 'textarea' ),
        'vt_announcement' => array( 'متن نوار اطلاع‌رسانی', 'آماده برای مسیرهای سخت؛ خرید آسان تجهیزات آفرود', 'text' ),
    );
    foreach ( $settings as $id => $meta ) {
        $sanitize = 'sanitize_text_field';
        if ( $meta[2] === 'textarea' ) { $sanitize = 'sanitize_textarea_field'; }
        if ( $meta[2] === 'url' ) { $sanitize = 'esc_url_raw'; }
        $customizer->add_setting( $id, array( 'default' => $meta[1], 'sanitize_callback' => $sanitize ) );
        $customizer->add_control( $id, array( 'label' => $meta[0], 'section' => 'vt_store', 'type' => $meta[2] ) );
    }
}
add_action( 'customize_register', 'vt_customize' );

function vt_has_woocommerce() { return class_exists( 'WooCommerce' ); }
function vt_shop_url() {
    return vt_has_woocommerce() ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/?post_type=product' );
}
function vt_category_url( $slug ) {
    $term = get_term_by( 'slug', $slug, 'product_cat' );
    if ( $term && ! is_wp_error( $term ) ) {
        $url = get_term_link( $term );
        if ( ! is_wp_error( $url ) ) { return $url; }
    }
    return vt_shop_url();
}
function vt_cart_url() { return vt_has_woocommerce() ? wc_get_cart_url() : home_url( '/' ); }
function vt_cart_count() { return vt_has_woocommerce() && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; }
function vt_account_url() { return vt_has_woocommerce() ? wc_get_page_permalink( 'myaccount' ) : wp_login_url(); }

function vt_icon( $name, $class = '' ) {
    $paths = array(
        'bag' => '<path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/>',
        'user' => '<circle cx="12" cy="8" r="3.3"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/>',
        'search' => '<circle cx="10.8" cy="10.8" r="6.3"/><path d="m16 16 4.2 4.2"/>',
        'arrow' => '<path d="M19 12H5m0 0 6-6m-6 6 6 6"/>',
        'chevron' => '<path d="m15 18-6-6 6-6"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="m5 5 14 14M19 5 5 19"/>',
        'shield' => '<path d="m12 2 8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4Z"/><path d="m8 12 2.5 2.5L16 9"/>',
        'truck' => '<path d="M2 6h12v11H2zM14 10h4l4 4v3h-8z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>',
        'support' => '<path d="M4 13v-2a8 8 0 0 1 16 0v2M4 13h3v6H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 1-2Zm16 0h-3v6h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-1-2ZM20 19a5 5 0 0 1-5 3h-3"/>',
        'filter' => '<path d="M4 7h16M7 12h10M10 17h4"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/>',
        'star' => '<path d="m12 2 3 6.5 7 .8-5.2 4.9 1.4 7-6.2-3.5-6.2 3.5 1.4-7L2 9.3l7-.8L12 2Z"/>',
        'check' => '<path d="m4 12 5 5L20 6"/>',
    );
    if ( ! isset( $paths[ $name ] ) ) { return; }
    echo '<svg class="vt-icon ' . esc_attr( $class ) . '" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $paths[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function vt_product_art( $product ) {
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    $slug = 'helmet';
    if ( ! is_wp_error( $terms ) && $terms ) {
        $allowed = array( 'helmets' => 'helmet', 'goggles' => 'goggles', 'gloves' => 'gloves', 'boots' => 'boots', 'armor' => 'armor', 'parts' => 'parts' );
        foreach ( $terms as $term ) {
            if ( isset( $allowed[ $term->slug ] ) ) { $slug = $allowed[ $term->slug ]; break; }
        }
    }
    return get_template_directory_uri() . '/assets/img/' . $slug . '.svg';
}

function vt_currency_notice() {
    if ( ! vt_has_woocommerce() ) { return; }
    if ( is_admin() && current_user_can( 'activate_plugins' ) ) {
        // Displayed only when WooCommerce is unavailable, so no notices here.
    }
}
function vt_woo_wrapper_start() { echo '<main id="main-content" class="vt-wc-main"><div class="vt-container">'; }
function vt_woo_wrapper_end() { echo '</div></main>'; }
add_action( 'after_setup_theme', function() {
    if ( vt_has_woocommerce() ) {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
        add_action( 'woocommerce_before_main_content', 'vt_woo_wrapper_start', 10 );
        add_action( 'woocommerce_after_main_content', 'vt_woo_wrapper_end', 10 );
    }
}, 20 );
add_filter( 'loop_shop_columns', function() { return 3; } );
add_filter( 'woocommerce_output_related_products_args', function( $args ) { $args['posts_per_page'] = 3; $args['columns'] = 3; return $args; } );
add_filter( 'woocommerce_breadcrumb_defaults', function( $args ) { $args['delimiter'] = '<span class="vt-breadcrumb-separator">/</span>'; $args['home'] = 'خانه'; return $args; } );

function vt_wc_missing_notice() {
    if ( ! vt_has_woocommerce() && current_user_can( 'activate_plugins' ) ) {
        echo '<div class="notice notice-warning"><p>برای فعال‌شدن فروشگاه وحید تیونینگ، افزونه WooCommerce را نصب و فعال کنید.</p></div>';
    }
}
add_action( 'admin_notices', 'vt_wc_missing_notice' );

// Cart fragments keep the header count accurate with classic AJAX add-to-cart.
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $fragments['span.vt-cart-count'] = '<span class="vt-cart-count">' . esc_html( (string) vt_cart_count() ) . '</span>';
    return $fragments;
} );
