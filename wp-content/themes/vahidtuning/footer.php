<?php
/** Store footer. @package VahidTuning */
defined( 'ABSPATH' ) || exit;
$phone = get_theme_mod( 'vt_phone', '' );
$instagram = get_theme_mod( 'vt_instagram', '' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'vt_whatsapp', '' ) );
$address = get_theme_mod( 'vt_address', '' );
?>
<footer class="vt-footer">
    <div class="vt-container">
        <div class="vt-footer-top">
            <div class="vt-footer-about">
                <?php vt_brand(); ?>
                <p>فروشگاه تخصصی تجهیزات موتور تریل، اندرو و آفرود.</p>
            </div>
            <div class="vt-footer-column">
                <h3>خرید</h3>
                <a href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات</a>
                <a href="<?php echo esc_url( vt_cart_url() ); ?>">سبد خرید</a>
                <a href="<?php echo esc_url( vt_account_url() ); ?>">حساب و پیگیری سفارش</a>
            </div>
            <div class="vt-footer-column">
                <h3>تجهیزات</h3>
                <?php foreach ( vt_catalog_categories() as $slug => $category ) : ?>
                    <a href="<?php echo esc_url( vt_category_url( $slug ) ); ?>"><?php echo esc_html( $category['name'] ); ?></a>
                <?php endforeach; ?>
            </div>
            <?php if ( $phone || $address || $instagram || $whatsapp ) : ?>
                <div class="vt-footer-column">
                    <h3>ارتباط با فروشگاه</h3>
                    <?php if ( $phone ) : ?><a dir="ltr" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
                    <?php if ( $address ) : ?><p><?php echo nl2br( esc_html( $address ) ); ?></p><?php endif; ?>
                    <?php if ( $instagram ) : ?><a href="<?php echo esc_url( $instagram ); ?>">اینستاگرام</a><?php endif; ?>
                    <?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>">واتساپ</a><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="vt-footer-bottom">© <?php echo esc_html( vt_format_number( wp_date( 'Y' ) ) ); ?> وحید تیونینگ</div>
    </div>
</footer>
<?php if ( vt_has_woocommerce() ) : ?>
    <nav class="vt-mobile-dock" aria-label="دسترسی سریع فروشگاه">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php if ( is_front_page() ) : ?> aria-current="page"<?php endif; ?>><?php vt_icon( 'home' ); ?><span>خانه</span></a>
        <a href="<?php echo esc_url( vt_shop_url() ); ?>"<?php if ( is_shop() ) : ?> aria-current="page"<?php endif; ?>><?php vt_icon( 'grid' ); ?><span>فروشگاه</span></a>
        <a href="<?php echo esc_url( vt_cart_url() ); ?>"<?php if ( is_cart() ) : ?> aria-current="page"<?php endif; ?>><?php vt_icon( 'bag' ); ?><span>سبد خرید</span></a>
        <a href="<?php echo esc_url( vt_account_url() ); ?>"<?php if ( is_account_page() ) : ?> aria-current="page"<?php endif; ?>><?php vt_icon( 'user' ); ?><span>حساب من</span></a>
    </nav>
<?php endif; ?>
<?php wp_footer(); ?>
</body></html>
