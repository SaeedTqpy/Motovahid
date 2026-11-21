<?php
/**
 * Plugin Name: MotoVahid - Demo Catalog
 * Description: Non-destructive, one-click Persian sample catalog for WooCommerce.
 * Version: 1.0.0
 * Requires PHP: 8.0
 * Requires Plugins: woocommerce
 * Text Domain: vahidtuning-demo
 */
defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function() {
    add_management_page( 'محصولات نمونه موتو وحید', 'محصولات نمونه موتو وحید', 'manage_options', 'vt-demo-products', 'vt_demo_admin_screen' );
} );

function vt_demo_admin_screen() {
    if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_html__( 'Access denied.' ) ); }
    ?>
    <div class="wrap" dir="rtl">
        <h1>وارد کردن محصولات نمونه موتو وحید</h1>
        <?php if ( isset( $_GET['vt_imported'] ) ) : ?>
            <div class="notice notice-success"><p>تعداد <?php echo esc_html( (string) absint( $_GET['vt_imported'] ) ); ?> محصول جدید ساخته شد. محصولات قبلی و تنظیمات فروشگاه حفظ شدند.</p></div>
        <?php endif; ?>
        <?php if ( ! class_exists( 'WooCommerce' ) ) : ?>
            <div class="notice notice-error"><p>ابتدا افزونه WooCommerce را نصب و فعال کنید.</p></div>
        <?php else : ?>
            <p>این عملیات ۶ دسته‌بندی و ۱۸ محصول آزمایشی فارسی با قیمت به تومان و موجودی نمونه ایجاد می‌کند. محصولات دارای سایز، تنوع قابل انتخاب خواهند داشت.</p>
            <p><strong>مهم:</strong> نام، قیمت و موجودی همگی ساختگی هستند. پیش از راه‌اندازی عمومی، آن‌ها را با داده‌های واقعی جایگزین کنید.</p>
            <p>اجرای مجدد به‌دلیل استفاده از شناسه SKU، محصولات تکراری ایجاد نمی‌کند و هیچ محصول واقعی را حذف نمی‌کند.</p>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="vt_import_demo">
                <?php wp_nonce_field( 'vt_import_demo', 'vt_demo_nonce' ); ?>
                <?php submit_button( 'ساخت محصولات نمونه', 'primary', 'submit', false ); ?>
            </form>
        <?php endif; ?>
    </div>
    <?php
}

add_action( 'admin_post_vt_import_demo', function() {
    if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'دسترسی غیرمجاز', '', array( 'response' => 403 ) ); }
    check_admin_referer( 'vt_import_demo', 'vt_demo_nonce' );
    if ( ! class_exists( 'WooCommerce' ) ) { wp_die( 'ابتدا ووکامرس را فعال کنید.', '', array( 'response' => 400 ) ); }

    $categories = array(
        'helmets' => 'کلاه کاسکت',
        'goggles' => 'عینک و شیلد',
        'gloves' => 'دستکش موتور',
        'boots' => 'بوت و پوشاک',
        'armor' => 'لوازم ایمنی',
        'parts' => 'قطعات و لوازم فنی',
    );
    $term_ids = array();
    foreach ( $categories as $slug => $name ) {
        $existing = get_term_by( 'slug', $slug, 'product_cat' );
        if ( $existing ) {
            $term_ids[ $slug ] = (int) $existing->term_id;
            continue;
        }
        $new = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug, 'description' => 'تجهیزات تخصصی ' . $name . ' برای موتور تریل و آفرود' ) );
        if ( ! is_wp_error( $new ) ) { $term_ids[ $slug ] = (int) $new['term_id']; }
    }

    // sku, Persian title, category, regular Toman price, optional sale price, optional variations.
    $items = array(
        array( 'VT-H001', 'کلاه کراس نئون مدل MX-01', 'helmets', 8950000, 8250000, array( 'M', 'L', 'XL' ) ),
        array( 'VT-H002', 'کلاه اندرو مشکی مدل ADV-7', 'helmets', 11900000, 0, array( 'M', 'L', 'XL' ) ),
        array( 'VT-H003', 'کلاه تریل خاکستری مدل AERO R', 'helmets', 7450000, 0, array() ),
        array( 'VT-G001', 'عینک کراس لنز آینه‌ای VISION X', 'goggles', 2190000, 1890000, array() ),
        array( 'VT-G002', 'شیلد یدکی شفاف مخصوص آفرود', 'goggles', 890000, 0, array() ),
        array( 'VT-G003', 'عینک ضد بخار مدل TRAIL PRO', 'goggles', 1850000, 0, array() ),
        array( 'VT-L001', 'دستکش کراس مدل GRIP-X', 'gloves', 1480000, 1190000, array( 'S', 'M', 'L', 'XL' ) ),
        array( 'VT-L002', 'دستکش تریل تنفسی مدل PRO-VENT', 'gloves', 1920000, 0, array( 'M', 'L', 'XL' ) ),
        array( 'VT-B001', 'بوت اندرو مدل X-GUARD', 'boots', 14850000, 0, array( '42', '43', '44' ) ),
        array( 'VT-B002', 'بوت موتور تریل مدل RIDER', 'boots', 11500000, 10800000, array( '42', '43', '44' ) ),
        array( 'VT-A001', 'زره سینه آفرود مدل SHIELD CORE', 'armor', 8400000, 0, array() ),
        array( 'VT-A002', 'زانوبند محافظ مدل FLEX', 'armor', 3800000, 0, array() ),
        array( 'VT-A003', 'آرنج‌بند سبک مدل ENDURO LIGHT', 'armor', 2100000, 0, array() ),
        array( 'VT-P001', 'دیسک ترمز آفرود مدل XT', 'parts', 2650000, 0, array() ),
        array( 'VT-P002', 'گارد هندل‌بار آلومینیومی', 'parts', 1850000, 0, array() ),
        array( 'VT-P003', 'گارد دست تقویت‌شده تریل', 'parts', 1590000, 0, array() ),
        array( 'VT-P004', 'دسته گاز موتور تریل', 'parts', 920000, 0, array() ),
        array( 'VT-P005', 'چراغ کمکی پروژکتور آفرود', 'parts', 1290000, 0, array() ),
    );

    $created = 0;
    foreach ( $items as $entry ) {
        list( $sku, $name, $category, $regular, $sale, $sizes ) = $entry;
        if ( wc_get_product_id_by_sku( $sku ) || ! isset( $term_ids[ $category ] ) ) { continue; }
        try {
            $product = $sizes ? new WC_Product_Variable() : new WC_Product_Simple();
            $product->set_name( $name );
            $product->set_status( 'publish' );
            $product->set_catalog_visibility( 'visible' );
            $product->set_sku( $sku );
            $product->set_category_ids( array( $term_ids[ $category ] ) );
            $product->set_description( 'محصول نمایشی فروشگاه موتو وحید برای بررسی امکانات سایت. مشخصات فنی، موجودی و قیمت آزمایشی هستند و باید پیش از فروش واقعی بررسی و جایگزین شوند.' );
            $product->set_short_description( 'انتخابی مناسب برای تکمیل تجهیزات آفرود و موتور تریل. اطلاعات محصول نمونه است.' );
            if ( $sizes ) {
                $attribute = new WC_Product_Attribute();
                $attribute->set_id( 0 );
                $attribute->set_name( 'سایز' );
                $attribute->set_options( $sizes );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $product->set_attributes( array( $attribute ) );
            } else {
                $product->set_regular_price( (string) $regular );
                if ( $sale ) { $product->set_sale_price( (string) $sale ); }
                $product->set_manage_stock( true );
                $product->set_stock_quantity( 16 );
                $product->set_stock_status( 'instock' );
            }
            $id = $product->save();
            if ( $sizes ) {
                foreach ( $sizes as $size ) {
                    $variation = new WC_Product_Variation();
                    $variation->set_parent_id( $id );
                    $variation->set_attributes( array( 'سایز' => $size ) );
                    $variation->set_regular_price( (string) $regular );
                    if ( $sale ) { $variation->set_sale_price( (string) $sale ); }
                    $variation->set_manage_stock( true );
                    $variation->set_stock_quantity( 8 );
                    $variation->set_stock_status( 'instock' );
                    $variation->save();
                }
                WC_Product_Variable::sync( $id );
            }
            ++$created;
        } catch ( Exception $error ) {
            error_log( 'MotoVahid demo import: ' . $sku . ': ' . $error->getMessage() );
        }
    }
    // These settings are applied only on explicit admin action; real store settings remain editable.
    update_option( 'woocommerce_currency', 'IRT' );
    update_option( 'woocommerce_currency_pos', 'right_space' );
    update_option( 'woocommerce_price_num_decimals', '0' );
    update_option( 'woocommerce_price_thousand_sep', '٬' );
    update_option( 'woocommerce_price_decimal_sep', '٫' );
    wp_safe_redirect( add_query_arg( 'vt_imported', $created, admin_url( 'tools.php?page=vt-demo-products' ) ) );
    exit;
} );
