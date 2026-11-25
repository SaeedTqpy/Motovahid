<?php
/** Discounted products on the homepage. */
if ( ! vt_has_woocommerce() ) { return; }
$sale_ids = wc_get_product_ids_on_sale();
if ( ! $sale_ids ) { return; }
$candidates = wc_get_products( array( 'status' => 'publish', 'include' => $sale_ids, 'limit' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
$sale_products = array();
foreach ( $candidates as $item ) {
    if ( $item->is_visible() && $item->is_on_sale() ) { $sale_products[] = $item; }
    if ( count( $sale_products ) >= 12 ) { break; }
}
if ( ! $sale_products ) { return; }
?>
<section class="nt-sale" aria-labelledby="vt-sale-title" data-sale-carousel>
    <div class="vt-container nt-sale-inner">
        <div class="nt-sale-heading">
            <div class="nt-sale-intro">
                <span class="nt-sale-kicker"><span aria-hidden="true"></span> تخفیف‌های فروشگاه</span>
                <h2 id="vt-sale-title">تجهیزات مسیر،<br><em>با تخفیف</em></h2>
                <p>محصولات تخفیف‌خورده را ببینید.</p>
            </div>
            <div class="nt-sale-side">
                <span class="nt-sale-mark" aria-hidden="true">SALE<span>/</span></span>
                <div class="nt-sale-controls" hidden>
                    <button type="button" data-sale-prev aria-label="محصولات قبلی"><span aria-hidden="true">→</span></button>
                    <button type="button" data-sale-next aria-label="محصولات بعدی"><span aria-hidden="true">←</span></button>
                </div>
            </div>
        </div>
        <div class="nt-sale-track" id="vt-sale-track" tabindex="0" aria-label="محصولات تخفیف‌خورده">
            <?php foreach ( $sale_products as $sale_product ) :
                $discount = vt_product_discount_percent( $sale_product );
                $terms = get_the_terms( $sale_product->get_id(), 'product_cat' );
                $category = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'تجهیزات موتور';
                ?>
                <article class="nt-sale-card">
                    <div class="vt-card-media">
                    <a class="nt-sale-image" href="<?php echo esc_url( get_permalink( $sale_product->get_id() ) ); ?>" aria-label="<?php echo esc_attr( $sale_product->get_name() ); ?>">
                        <span class="nt-sale-badge"><?php echo $discount ? esc_html( vt_format_number( $discount ) . '٪ تخفیف' ) : 'تخفیف ویژه'; ?></span>
                        <?php if ( $sale_product->get_image_id() ) : ?>
                            <?php echo wp_kses_post( $sale_product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( vt_product_art( $sale_product ) ); ?>" alt="" width="520" height="470" loading="lazy">
                        <?php endif; ?>
                    </a>
                    <?php vt_product_card_actions( $sale_product ); ?>
                    </div>
                    <div class="nt-sale-card-body">
                        <span class="nt-sale-category"><?php echo esc_html( $category ); ?></span>
                        <h3><a href="<?php echo esc_url( get_permalink( $sale_product->get_id() ) ); ?>"><?php echo esc_html( $sale_product->get_name() ); ?></a></h3>
                        <div class="nt-sale-bottom">
                            <div class="nt-sale-price"><?php echo wp_kses_post( vt_persian_price_html( $sale_product->get_price_html() ) ); ?></div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="nt-sale-footer"><span>منتخب تخفیف‌های موتو وحید</span><a href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده فروشگاه</a></div>
    </div>
</section>
