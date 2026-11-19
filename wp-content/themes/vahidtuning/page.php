<?php
/** Content page / WooCommerce cart and checkout blocks. */
get_header(); ?>
<main id="main-content" class="vt-page vt-container">
<?php while ( have_posts() ) : the_post();
    $title = get_the_title();
    $purchase_screen = vt_purchase_screen();
    if ( vt_has_woocommerce() ) {
        $store_titles = array( 'cart' => 'سبد خرید', 'checkout' => 'تسویه‌حساب', 'myaccount' => 'حساب کاربری' );
        foreach ( $store_titles as $store_page => $store_title ) {
            if ( get_the_ID() === wc_get_page_id( $store_page ) ) {
                $title = $store_title;
                break;
            }
        }
    }
    ?>
    <article <?php post_class( $purchase_screen ? 'vt-entry vt-purchase vt-purchase--' . $purchase_screen : 'vt-entry' ); ?>>
        <?php if ( $purchase_screen ) : ?>
            <nav class="vt-purchase-progress" aria-label="مراحل خرید">
                <ol>
                    <li><?php if ( 'cart' === $purchase_screen ) : ?><span aria-current="step"><?php vt_icon( 'bag' ); ?> سبد خرید</span><?php else : ?><a href="<?php echo esc_url( vt_cart_url() ); ?>"><?php vt_icon( 'bag' ); ?> سبد خرید</a><?php endif; ?></li>
                    <li><?php vt_icon( 'chevron' ); ?><span<?php if ( 'checkout' === $purchase_screen ) : ?> aria-current="step"<?php endif; ?>>تسویه‌حساب</span></li>
                </ol>
            </nav>
        <?php endif; ?>
        <div class="vt-page-head">
            <h1><?php echo esc_html( $title ); ?></h1>
            <?php if ( 'cart' === $purchase_screen ) : ?>
                <a class="vt-text-link" href="<?php echo esc_url( vt_shop_url() ); ?>">ادامه خرید <?php vt_icon( 'arrow' ); ?></a>
            <?php endif; ?>
        </div>
        <div class="vt-entry-content"><?php the_content(); ?></div>
    </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
