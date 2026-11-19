<?php
/** Catalog listing with native WooCommerce queries and pagination. */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );

$catalog_url = vt_shop_url();
if ( is_search() ) {
    $catalog_url = home_url( '/' );
} elseif ( is_product_taxonomy() ) {
    $term_url = get_term_link( get_queried_object() );
    if ( ! is_wp_error( $term_url ) ) { $catalog_url = $term_url; }
}

$filter_params = array();
parse_str( wp_parse_url( $catalog_url, PHP_URL_QUERY ) ?? '', $filter_params );
if ( is_search() ) {
    $filter_params['s'] = get_search_query( false );
    $filter_params['post_type'] = 'product';
}
if ( isset( $_GET['orderby'] ) && is_string( $_GET['orderby'] ) ) {
    $filter_params['orderby'] = sanitize_text_field( wp_unslash( $_GET['orderby'] ) );
}
$min_price = isset( $_GET['min_price'] ) && is_string( $_GET['min_price'] ) ? wc_format_decimal( wp_unslash( $_GET['min_price'] ) ) : '';
$max_price = isset( $_GET['max_price'] ) && is_string( $_GET['max_price'] ) ? wc_format_decimal( wp_unslash( $_GET['max_price'] ) ) : '';
$has_price_filter = '' !== $min_price || '' !== $max_price;
$currency = get_woocommerce_currency_symbol();
$category_links = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
?>
<header class="woocommerce-products-header vt-catalog-header">
    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
        <h1 class="woocommerce-products-header__title page-title"><?php if ( is_search() ) : ?>نتایج جستجو برای «<?php echo esc_html( get_search_query( false ) ); ?>»<?php elseif ( is_shop() ) : ?>فروشگاه تجهیزات<?php else : ?><?php woocommerce_page_title(); ?><?php endif; ?></h1>
    <?php endif; ?>
    <?php do_action( 'woocommerce_archive_description' ); ?>
    <?php if ( ! is_wp_error( $category_links ) && $category_links ) : ?>
        <nav class="vt-catalog-categories" aria-label="دسته‌بندی محصولات">
            <a href="<?php echo esc_url( vt_shop_url() ); ?>"<?php if ( is_shop() && ! is_search() ) : ?> aria-current="page"<?php endif; ?>>همه محصولات</a>
            <?php foreach ( $category_links as $category ) :
                $category_link = get_term_link( $category );
                if ( is_wp_error( $category_link ) ) { continue; }
                ?>
                <a href="<?php echo esc_url( $category_link ); ?>"<?php if ( is_tax( 'product_cat', $category->term_id ) ) : ?> aria-current="page"<?php endif; ?>><?php echo esc_html( $category->name ); ?></a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
</header>
<div class="vt-shop-main">
    <?php $has_products = woocommerce_product_loop(); ?>
    <div class="vt-shop-toolbar">
        <p class="vt-catalog-count"><?php echo esc_html( vt_format_number( (int) wc_get_loop_prop( 'total' ) ) ); ?> محصول</p>
        <div class="vt-catalog-controls">
            <?php
            if ( $has_products ) {
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
                do_action( 'woocommerce_before_shop_loop' );
                add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            }
            ?>
            <details class="vt-price-disclosure">
                <summary><?php vt_icon( 'filter' ); ?> فیلتر قیمت<?php if ( $has_price_filter ) : ?><span class="vt-filter-active-dot" aria-label="فعال"></span><?php endif; ?></summary>
                <form method="get" action="<?php echo esc_url( strtok( $catalog_url, '?' ) ); ?>">
                    <h2>محدوده قیمت (<?php echo esc_html( $currency ); ?>)</h2>
                    <div class="vt-price-fields">
                        <label>از<input type="number" inputmode="decimal" min="0" step="any" name="min_price" value="<?php echo esc_attr( $min_price ); ?>" placeholder="حداقل"></label>
                        <label>تا<input type="number" inputmode="decimal" min="0" step="any" name="max_price" value="<?php echo esc_attr( $max_price ); ?>" placeholder="حداکثر"></label>
                    </div>
                    <?php foreach ( $filter_params as $key => $value ) : ?>
                        <?php if ( is_scalar( $value ) ) : ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>"><?php endif; ?>
                    <?php endforeach; ?>
                    <button class="vt-btn vt-btn-primary" type="submit">اعمال فیلتر</button>
                    <?php if ( $has_price_filter ) : ?>
                        <a class="vt-text-link" href="<?php echo esc_url( add_query_arg( array_map( 'rawurlencode', $filter_params ), $catalog_url ) ); ?>">پاک کردن فیلتر قیمت</a>
                    <?php endif; ?>
                </form>
            </details>
        </div>
    </div>

    <?php if ( $has_products ) : ?>
        <?php woocommerce_product_loop_start(); ?>
        <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
            <?php while ( have_posts() ) : the_post(); do_action( 'woocommerce_shop_loop' ); wc_get_template_part( 'content', 'product' ); endwhile; ?>
        <?php endif; ?>
        <?php woocommerce_product_loop_end(); do_action( 'woocommerce_after_shop_loop' ); ?>
    <?php else : ?>
        <div class="vt-empty-products">
            <span class="vt-empty-icon"><?php vt_icon( 'search' ); ?></span>
            <div>
                <strong>محصولی پیدا نشد</strong>
                <?php if ( is_search() || $has_price_filter ) : ?>
                    <p>عبارت جستجو یا محدودهٔ قیمت را تغییر بده.</p>
                    <a class="vt-text-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات <?php vt_icon( 'arrow' ); ?></a>
                <?php else : ?>
                    <p>هنوز محصولی در این بخش ثبت نشده است.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        remove_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );
        do_action( 'woocommerce_no_products_found' );
        add_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );
        ?>
    <?php endif; ?>
</div>
<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
