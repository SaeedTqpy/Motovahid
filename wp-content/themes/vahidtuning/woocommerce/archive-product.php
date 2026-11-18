<?php
/**
 * Catalog listing with functional native WooCommerce filters.
 * @package VahidTuning
 */
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );
?>
<header class="woocommerce-products-header vt-catalog-header">
    <p class="vt-section-overline"><span></span> TRAIL EQUIPMENT / SHOP</p>
    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>
    <?php do_action( 'woocommerce_archive_description' ); ?>
</header>
<div class="vt-shop-layout">
    <aside class="vt-shop-sidebar" id="vt-filter-panel" aria-label="فیلتر محصولات">
        <h2>دسته‌بندی تجهیزات</h2>
        <ul class="vt-side-list">
            <li><a href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات</a></li>
            <?php
            $cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
            if ( ! is_wp_error( $cats ) ) :
                foreach ( $cats as $cat ) :
                    if ( 'uncategorized' === $cat->slug ) { continue; }
                    $link = get_term_link( $cat );
                    if ( is_wp_error( $link ) ) { continue; }
                    ?>
                    <li class="<?php echo is_tax( 'product_cat', $cat->term_id ) ? 'current' : ''; ?>"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $cat->name ); ?> <span><?php echo esc_html( (string) $cat->count ); ?></span></a></li>
                <?php endforeach;
            endif; ?>
        </ul>
        <h3>محدوده قیمت</h3>
        <form method="get" action="<?php echo esc_url( is_tax( 'product_cat' ) ? get_term_link( get_queried_object() ) : vt_shop_url() ); ?>">
            <div class="vt-price-fields">
                <label>از (تومان)<input type="number" inputmode="numeric" min="0" name="min_price" value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['min_price'] ) ) ) : ''; ?>" placeholder="حداقل"></label>
                <label>تا (تومان)<input type="number" inputmode="numeric" min="0" name="max_price" value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['max_price'] ) ) ) : ''; ?>" placeholder="حداکثر"></label>
            </div>
            <?php
            if ( isset( $_GET['orderby'] ) ) { echo '<input type="hidden" name="orderby" value="' . esc_attr( wc_clean( wp_unslash( $_GET['orderby'] ) ) ) . '">'; }
            if ( isset( $_GET['s'] ) ) { echo '<input type="hidden" name="s" value="' . esc_attr( get_search_query() ) . '">'; }
            if ( isset( $_GET['post_type'] ) ) { echo '<input type="hidden" name="post_type" value="product">'; }
            ?>
            <button class="vt-btn vt-btn-primary vt-filter-apply" type="submit">اعمال فیلتر</button>
        </form>
    </aside>
    <div class="vt-shop-main">
    <?php if ( woocommerce_product_loop() ) : ?>
        <div class="vt-shop-toolbar">
            <button type="button" class="vt-shop-filter-toggle" data-vt-filter-toggle aria-controls="vt-filter-panel" aria-expanded="false"><?php vt_icon( 'filter' ); ?> فیلتر</button>
            <?php do_action( 'woocommerce_before_shop_loop' ); ?>
        </div>
        <?php woocommerce_product_loop_start(); ?>
        <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
            <?php while ( have_posts() ) : the_post(); do_action( 'woocommerce_shop_loop' ); wc_get_template_part( 'content', 'product' ); endwhile; ?>
        <?php endif; ?>
        <?php woocommerce_product_loop_end(); do_action( 'woocommerce_after_shop_loop' ); ?>
    <?php else : ?>
        <?php do_action( 'woocommerce_no_products_found' ); ?>
    <?php endif; ?>
    </div>
</div>
<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
