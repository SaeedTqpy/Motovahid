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
    echo '<div class="images vt-single-placeholder"><div class="woocommerce-product-gallery__wrapper"><img src="' . esc_url( vt_product_art( $product ) ) . '" alt="' . esc_attr( $product->get_name() ) . '" width="640" height="520"></div></div>';
}

function vt_product_discount_percent( $product ) {
    if ( ! $product->is_type( 'simple' ) || ! $product->is_on_sale() ) { return 0; }
    $regular = (float) $product->get_regular_price();
    $sale = (float) $product->get_sale_price();
    return $regular > 0 && $sale >= 0 && $sale < $regular ? (int) round( 100 * ( $regular - $sale ) / $regular ) : 0;
}

function vt_pdp_open_gallery() {
    echo '<div class="vt-pdp-hero"><div class="vt-pdp-media">';
}

function vt_pdp_close_gallery() {
    echo '</div>';
}

function vt_pdp_category() {
    global $product;
    $categories = get_the_terms( $product->get_id(), 'product_cat' );
    if ( ! $categories || is_wp_error( $categories ) ) { return; }
    $default_category = (int) get_option( 'default_product_cat' );
    foreach ( $categories as $category ) {
        if ( $default_category === (int) $category->term_id ) { continue; }
        $url = get_term_link( $category );
        if ( is_wp_error( $url ) ) { continue; }
        echo '<a class="vt-pdp-category" href="' . esc_url( $url ) . '">';
        vt_icon( 'grid' );
        echo esc_html( $category->name ) . '</a>';
        break;
    }
}

function vt_pdp_price() {
    global $product;
    $price = $product->get_price_html();
    if ( '' === $price ) { return; }
    $discount = vt_product_discount_percent( $product );
    ?>
    <div class="vt-pdp-price">
        <div class="vt-pdp-price-heading">
            <span>قیمت محصول</span>
            <?php if ( $discount ) : ?><strong><?php echo esc_html( vt_format_number( $discount ) ); ?>٪ تخفیف</strong><?php endif; ?>
        </div>
        <div class="price vt-pdp-price-amount"><?php echo wp_kses_post( vt_persian_price_html( $price ) ); ?></div>
    </div>
    <?php
}

function vt_pdp_open_purchase() {
    echo '<div id="vt-pdp-purchase" class="vt-pdp-purchase" tabindex="-1">';
}

function vt_pdp_close_purchase() {
    echo '</div>';
}

function vt_pdp_trust() {
    ?>
    <ul class="vt-pdp-trust" aria-label="خدمات فروشگاه">
        <li><?php vt_icon( 'truck' ); ?><span><strong>ارسال سفارش</strong><small>جزئیات در مرحله تسویه‌حساب</small></span></li>
        <li><?php vt_icon( 'support' ); ?><span><strong>پیگیری سفارش</strong><small>از بخش حساب کاربری</small></span></li>
        <li><?php vt_icon( 'shield' ); ?><span><strong>خرید امن</strong><small>پرداخت از طریق درگاه فروشگاه</small></span></li>
    </ul>
    <?php
}

function vt_pdp_close_hero() {
    global $product;
    echo '</div>';
    if ( ! $product->is_purchasable() || ! $product->is_in_stock() || ! $product->is_type( array( 'simple', 'variable' ) ) ) { return; }
    ?>
    <div class="vt-pdp-mobile-buy" data-vt-mobile-buy hidden>
        <div class="vt-pdp-mobile-price">
            <?php echo wp_kses_post( vt_persian_price_html( $product->get_price_html() ) ); ?>
        </div>
        <a class="vt-btn vt-btn-accent" href="#vt-pdp-purchase"><?php vt_icon( 'bag' ); ?> <?php echo $product->is_type( 'variable' ) ? 'انتخاب گزینه‌ها' : 'رفتن به خرید'; ?></a>
    </div>
    <?php
}

add_action( 'wp', function() {
    if ( ! function_exists( 'is_product' ) || ! is_product() ) { return; }
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_before_single_product_summary', 'vt_pdp_open_gallery', 0 );
    add_action( 'woocommerce_before_single_product_summary', 'vt_pdp_close_gallery', 999 );
    add_action( 'woocommerce_single_product_summary', 'vt_pdp_category', 3 );
    add_action( 'woocommerce_single_product_summary', 'vt_pdp_open_purchase', 24 );
    add_action( 'woocommerce_single_product_summary', 'vt_pdp_price', 25 );
    add_action( 'woocommerce_single_product_summary', 'vt_pdp_close_purchase', 31 );
    add_action( 'woocommerce_single_product_summary', 'vt_pdp_trust', 32 );
    add_action( 'woocommerce_after_single_product_summary', 'vt_pdp_close_hero', 0 );
    $product = wc_get_product( get_queried_object_id() );
    if ( $product && ! $product->get_image_id() ) {
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        add_action( 'woocommerce_before_single_product_summary', 'vt_single_product_art', 20 );
    }
} );

add_filter( 'woocommerce_product_tabs', function( $tabs ) {
    global $product;
    if ( isset( $tabs['description'] ) ) { $tabs['description']['title'] = 'توضیحات محصول'; }
    if ( isset( $tabs['additional_information'] ) ) { $tabs['additional_information']['title'] = 'مشخصات فنی'; }
    if ( isset( $tabs['reviews'] ) && $product instanceof WC_Product ) {
        $tabs['reviews']['title'] = 'دیدگاه‌ها (' . vt_format_number( $product->get_review_count() ) . ')';
    }
    return $tabs;
}, 20 );
add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );
add_filter( 'woocommerce_product_related_products_heading', function() { return 'محصولات دیگر فروشگاه'; } );

add_filter( 'woocommerce_related_products', function( $related, $product_id, $args ) {
    if ( $related || ! is_product() || (int) get_queried_object_id() !== (int) $product_id ) { return $related; }
    $limit = (int) ( $args['limit'] ?? 3 );
    if ( $limit <= 0 ) { return $related; }
    $products = wc_get_products( array(
        'status' => 'publish',
        'limit' => $limit * 3,
        'exclude' => array_filter( array_merge( array( $product_id ), (array) ( $args['excluded_ids'] ?? array() ) ) ),
        'orderby' => 'date',
    ) );
    foreach ( $products as $product ) {
        if ( ! $product->is_visible() || ! $product->is_in_stock() ) { continue; }
        $related[] = $product->get_id();
        if ( count( $related ) === $limit ) { break; }
    }
    return $related;
}, 10, 3 );

// Untranslated WooCommerce string fallbacks for important storefront actions.
add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {
    if ( $product->is_type( 'variable' ) && $product->is_in_stock() ) { return 'انتخاب گزینه‌ها'; }
    if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) { return 'افزودن به سبد'; }
    if ( $product->is_type( array( 'simple', 'variable', 'grouped' ) ) ) { return 'مشاهده محصول'; }
    return $text;
}, 10, 2 );

add_filter( 'woocommerce_catalog_orderby', function( $options ) {
    $labels = array(
        'menu_order' => 'ترتیب پیش‌فرض',
        'popularity' => 'محبوب‌ترین',
        'rating'     => 'بالاترین امتیاز',
        'date'       => 'جدیدترین',
        'price'      => 'کمترین قیمت',
        'price-desc' => 'بیشترین قیمت',
        'relevance'  => 'مرتبط‌ترین',
    );
    return array_replace( $options, array_intersect_key( $labels, $options ) );
} );

// The local store can use an English site locale while the storefront is Persian.
add_filter( 'gettext_woocommerce', function( $translated, $source ) {
    if ( is_admin() && ! wp_doing_ajax() ) { return $translated; }
    $labels = array(
        'Shop'                      => 'فروشگاه',
        'Shop order'                => 'مرتب‌سازی محصولات',
        'View cart'                 => 'مشاهده سبد خرید',
        'Add to cart'               => 'افزودن به سبد',
        'Add to cart: “%s”'         => 'افزودن «%s» به سبد خرید',
        'Original price was: %s.'   => 'قیمت قبلی: %s.',
        'Current price is: %s.'     => 'قیمت فعلی: %s.',
        'View full-screen image gallery' => 'نمایش تمام‌صفحه گالری محصول',
        'In stock'                  => 'موجود',
        '%s in stock'               => '%s عدد موجود',
        'Out of stock'              => 'ناموجود',
        'Available on backorder'    => 'قابل سفارش',
        'SKU:'                      => 'شناسه کالا:',
        'Category:'                 => 'دسته‌بندی:',
        'Categories:'               => 'دسته‌بندی‌ها:',
        'Product quantity'          => 'تعداد محصول',
        '%s quantity'               => 'تعداد %s',
        'There are no reviews yet.' => 'هنوز دیدگاهی ثبت نشده است.',
        'Reviews'                   => 'دیدگاه‌ها',
        '%s has been added to your cart.' => '%s به سبد خرید اضافه شد.',
        '%s have been added to your cart.' => '%s به سبد خرید اضافه شدند.',
    );
    return $labels[ $source ] ?? $translated;
}, 10, 2 );

add_filter( 'ngettext_woocommerce', function( $translated, $single, $plural, $count ) {
    if ( is_admin() && ! wp_doing_ajax() ) { return $translated; }
    if ( '%s in stock' === $single ) {
        return '%s عدد موجود';
    }
    if ( '%s has been added to your cart.' === $single ) {
        return 1 === (int) $count ? '%s به سبد خرید اضافه شد.' : '%s به سبد خرید اضافه شدند.';
    }
    return $translated;
}, 10, 4 );
add_filter( 'woocommerce_get_stock_html', function( $html ) {
    return function_exists( 'is_product' ) && is_product() ? vt_persian_price_html( $html ) : $html;
} );

require_once __DIR__ . '/purchase.php';
