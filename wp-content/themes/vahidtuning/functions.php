<?php
/**
 * MotoVahid: bespoke, right-to-left WooCommerce storefront.
 *
 * @package MotoVahid
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'VT_HERO_TITLE', 'آماده مسیرهای فراتر از جاده' );
define( 'VT_HERO_DESCRIPTION', 'از کلاه و پوشاک موتورسواری تا تجهیزات ایمنی و قطعات موتور، تجهیزات موردنیاز مسیر را اینجا پیدا کنید.' );
define( 'VT_ANNOUNCEMENT', 'فروشگاه تخصصی تجهیزات موتور تریل و اندرو' );

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

/**
 * WordPress stores its site title in the database, not in the theme.
 * Rebrand existing default titles without altering unrelated custom titles.
 */
function vt_migrate_site_title_to_motovahid() {
    $old_title = (string) get_option( 'blogname', '' );
    $new_title = str_ireplace( array( 'Vahid Tuning', 'Vahidtuning' ), 'موتو وحید', $old_title );
    $new_title = str_replace( 'وحید تیونینگ', 'موتو وحید', $new_title );
    if ( $new_title !== $old_title ) {
        update_option( 'blogname', $new_title );
    }
}
add_action( 'init', 'vt_migrate_site_title_to_motovahid' );

function vt_enqueue_assets() {
    $dependencies = array_values( array_filter( array( 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen' ), function( $handle ) {
        return wp_style_is( $handle, 'enqueued' );
    } ) );
    wp_enqueue_style( 'vt-style', get_stylesheet_uri(), $dependencies, (string) filemtime( get_stylesheet_directory() . '/style.css' ) );
    $experience = 'assets/css/store-experience.css';
    wp_enqueue_style( 'vt-store-experience', get_theme_file_uri( $experience ), array( 'vt-style' ), (string) filemtime( get_theme_file_path( $experience ) ) );
    if ( is_front_page() ) {
        $home_styles = 'assets/css/home.css';
        wp_enqueue_style( 'vt-home', get_theme_file_uri( $home_styles ), array( 'vt-store-experience' ), (string) filemtime( get_theme_file_path( $home_styles ) ) );
    }
    if ( function_exists( 'is_product' ) && is_product() ) {
        $product_styles = 'assets/css/single-product.css';
        wp_enqueue_style( 'vt-single-product', get_theme_file_uri( $product_styles ), array( 'vt-store-experience' ), (string) filemtime( get_theme_file_path( $product_styles ) ) );
    }
    if ( vt_purchase_screen() ) {
        $purchase_styles = 'assets/css/purchase.css';
        wp_enqueue_style( 'vt-purchase', get_theme_file_uri( $purchase_styles ), array( 'vt-store-experience' ), (string) filemtime( get_theme_file_path( $purchase_styles ) ) );
    }
    // Load the WoodMart-inspired presentation after all page-specific theme styles.
    $inspired_styles = 'assets/css/woodmart-inspired.css';
    $inspired_dependencies = array_values( array_filter( array( 'vt-store-experience', 'vt-home', 'vt-single-product', 'vt-purchase' ), function( $handle ) {
        return wp_style_is( $handle, 'enqueued' );
    } ) );
    wp_enqueue_style( 'vt-woodmart-inspired', get_theme_file_uri( $inspired_styles ), $inspired_dependencies, (string) filemtime( get_theme_file_path( $inspired_styles ) ) );
    $commerce_styles = 'assets/css/woodmart-pages.css';
    wp_enqueue_style( 'vt-woodmart-pages', get_theme_file_uri( $commerce_styles ), array( 'vt-woodmart-inspired' ), (string) filemtime( get_theme_file_path( $commerce_styles ) ) );
    // Night Trail redesign: global layer, then the homepage layer.
    $night_styles = 'assets/css/night-trail.css';
    wp_enqueue_style( 'vt-night-trail', get_theme_file_uri( $night_styles ), array( 'vt-woodmart-pages' ), (string) filemtime( get_theme_file_path( $night_styles ) ) );
    if ( is_front_page() ) {
        wp_dequeue_style( 'vt-home' );
        $night_home = 'assets/css/night-trail-home.css';
        wp_enqueue_style( 'vt-night-trail-home', get_theme_file_uri( $night_home ), array( 'vt-night-trail' ), (string) filemtime( get_theme_file_path( $night_home ) ) );
    }
    wp_enqueue_script( 'vt-storefront', get_theme_file_uri( 'assets/js/storefront.js' ), array(), (string) filemtime( get_theme_file_path( 'assets/js/storefront.js' ) ), true );
}
add_action( 'wp_enqueue_scripts', 'vt_enqueue_assets' );

function vt_customize( $customizer ) {
    $customizer->add_section( 'vt_store', array( 'title' => 'تنظیمات فروشگاه موتو وحید', 'priority' => 32 ) );
    $settings = array(
        'vt_hero_title' => array( 'تیتر صفحه نخست', VT_HERO_TITLE, 'text' ),
        'vt_hero_description' => array( 'توضیح صفحه نخست', VT_HERO_DESCRIPTION, 'textarea' ),
        'vt_phone' => array( 'شماره تماس', '', 'text' ),
        'vt_instagram' => array( 'لینک اینستاگرام', '', 'url' ),
        'vt_whatsapp' => array( 'شماره واتساپ با کد کشور (بدون +)', '', 'text' ),
        'vt_address' => array( 'نشانی فروشگاه', '', 'textarea' ),
        'vt_map_location' => array( 'آدرس یا مختصات فروشگاه برای نمایش در نقشه', '', 'text' ),
        'vt_announcement' => array( 'متن نوار اطلاع‌رسانی', VT_ANNOUNCEMENT, 'text' ),
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

function vt_image_url( $filename ) { return get_theme_file_uri( 'assets/img/' . $filename ); }

function vt_format_number( $number ) {
    return strtr( (string) $number, array( '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹' ) );
}

function vt_persian_price_html( $html ) {
    $parts = wp_html_split( $html );
    foreach ( $parts as $index => $part ) {
        if ( 0 === $index % 2 && '' !== $part ) {
            $parts[ $index ] = esc_html( vt_format_number( html_entity_decode( $part, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
        }
    }
    return implode( '', $parts );
}

/** Use the brand image as a fallback when no site icon is set in WordPress. */
function vt_default_site_icon() {
    if ( has_site_icon() ) { return; }
    printf( '<link rel="icon" href="%s" type="image/jpeg">' . "\n", esc_url( vt_image_url( 'motovahid-logo.jpg' ) ) );
}
add_action( 'wp_head', 'vt_default_site_icon' );

function vt_brand() {
    ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vt-brand" aria-label="موتو وحید، صفحه اصلی">
        <img class="vt-brand-logo" src="<?php echo esc_url( vt_image_url( 'motovahid-logo.jpg' ) ); ?>" alt="" width="72" height="48">
        <span class="vt-brand-copy"><strong>موتو وحید</strong><img class="vt-brand-wordmark" src="<?php echo esc_url( vt_image_url( 'motovahid-wordmark.png' ) ); ?>" alt="" width="1400" height="174"></span>
    </a>
    <?php
}

function vt_catalog_categories() {
    return array(
        'helmets' => array( 'name' => 'کلاه کاسکت', 'image' => 'category-helmet.jpg' ),
        'goggles' => array( 'name' => 'عینک و شیلد', 'image' => 'category-goggles.jpg' ),
        'gloves'  => array( 'name' => 'دستکش موتور', 'image' => 'category-gloves.jpg' ),
        'boots'   => array( 'name' => 'بوت و پوشاک', 'image' => 'category-boots.jpg' ),
        'armor'   => array( 'name' => 'تجهیزات ایمنی', 'image' => 'category-armor.jpg' ),
        'parts'   => array( 'name' => 'قطعات و لوازم', 'image' => 'category-parts.jpg' ),
    );
}

function vt_home_products() {
    if ( ! vt_has_woocommerce() ) { return array(); }

    $products = wc_get_products( array( 'status' => 'publish', 'limit' => 24, 'orderby' => 'date', 'order' => 'DESC' ) );
    $featured = array();
    $recent = array();
    foreach ( $products as $product ) {
        if ( ! $product->is_visible() ) { continue; }
        if ( $product->is_featured() ) {
            $featured[] = $product->get_id();
        } else {
            $recent[] = $product->get_id();
        }
    }
    return array_slice( array_merge( $featured, $recent ), 0, 8 );
}

function vt_shop_url() {
    if ( vt_has_woocommerce() ) {
        if ( ! get_option( 'permalink_structure' ) ) {
            return add_query_arg( 'post_type', 'product', home_url( '/' ) );
        }
        $shop_id = wc_get_page_id( 'shop' );
        if ( $shop_id > 0 ) { return get_permalink( $shop_id ); }
        $archive = get_post_type_archive_link( 'product' );
        if ( $archive ) { return $archive; }
    }
    return home_url( '/?post_type=product' );
}
function vt_category_url( $slug ) {
    $term = get_term_by( 'slug', $slug, 'product_cat' );
    if ( $term && ! is_wp_error( $term ) ) {
        $url = get_term_link( $term );
        if ( ! is_wp_error( $url ) ) { return $url; }
    }
    $categories = vt_catalog_categories();
    if ( vt_has_woocommerce() && isset( $categories[ $slug ] ) ) {
        return add_query_arg( array( 's' => rawurlencode( $categories[ $slug ]['name'] ), 'post_type' => 'product' ), home_url( '/' ) );
    }
    return vt_shop_url();
}
function vt_cart_url() { return vt_has_woocommerce() ? wc_get_cart_url() : home_url( '/' ); }
function vt_cart_count() { return vt_has_woocommerce() && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; }
function vt_account_url() { return vt_has_woocommerce() ? wc_get_page_permalink( 'myaccount' ) : wp_login_url(); }

function vt_icon( $name, $class = '' ) {
    $paths = array(
        'heart' => '<path d="M20.8 4.9a5.5 5.5 0 0 0-7.8 0L12 6l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.3a5.5 5.5 0 0 0 0-7.8Z"/>',
        'eye' => '<path d="M2 12s3.5-6.5 10-6.5 10 6.5 10 6.5-3.5 6.5-10 6.5S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
        'bag' => '<path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/>',
        'home' => '<path d="m3 11 9-8 9 8M5 10v10h14V10m-9 10v-6h4v6"/>',
        'user' => '<circle cx="12" cy="8" r="3.3"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/>',
        'search' => '<circle cx="10.8" cy="10.8" r="6.3"/><path d="m16 16 4.2 4.2"/>',
        'arrow' => '<path d="M19 12H5m0 0 6-6m-6 6 6 6"/>',
        'down' => '<path d="M12 5v14m-5-5 5 5 5-5"/>',
        'grid' => '<rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/>',
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

/** Product-card controls; preserve WooCommerce's native add-to-cart behavior. */
function vt_product_card_actions( $item ) {
    global $product;
    $previous_product = $product;
    $product = $item;
    $url = get_permalink( $item->get_id() );
    ?>
    <div class="vt-card-quick-actions">
        <button type="button" class="vt-card-like" data-vt-like="<?php echo esc_attr( $item->get_id() ); ?>" aria-label="<?php echo esc_attr( 'پسندیدن ' . $item->get_name() ); ?>" aria-pressed="false" title="پسندیدن در این مرورگر" hidden><?php vt_icon( 'heart' ); ?></button>
        <a class="vt-card-view" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( 'مشاهده ' . $item->get_name() ); ?>" title="مشاهده محصول"><?php vt_icon( 'eye' ); ?></a>
    </div>
    <div class="vt-card-purchase vt-product-add"><?php woocommerce_template_loop_add_to_cart(); ?></div>
    <?php
    $product = $previous_product;
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
        echo '<div class="notice notice-warning"><p>برای فعال‌شدن فروشگاه موتو وحید، افزونه WooCommerce را نصب و فعال کنید.</p></div>';
    }
}
add_action( 'admin_notices', 'vt_wc_missing_notice' );

// Cart fragments keep the header count accurate with classic AJAX add-to-cart.
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $fragments['span.vt-cart-count'] = '<span class="vt-cart-count">' . esc_html( vt_format_number( vt_cart_count() ) ) . '</span>';
    return $fragments;
} );

require_once get_template_directory() . '/inc/woocommerce.php';
