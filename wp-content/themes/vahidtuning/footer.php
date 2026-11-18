<?php
/** Site footer. @package VahidTuning */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$phone = get_theme_mod( 'vt_phone', '' );
$instagram = get_theme_mod( 'vt_instagram', '' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'vt_whatsapp', '' ) );
$address = get_theme_mod( 'vt_address', '' );
?>
<footer class="vt-footer">
    <div class="vt-container">
        <div class="vt-footer-top">
            <div class="vt-footer-about">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vt-brand vt-brand-footer"><span class="vt-brand-symbol"><span>V</span><i></i></span><span class="vt-brand-copy"><strong>وحید تیونینگ</strong><small>تجهیزات موتور تریل و آفرود</small></span></a>
                <p>از اولین پیچ تا آخرین مسیر خاکی؛ فروشگاه تخصصی تجهیزات موتور تریل و آفرود.</p>
                <div class="vt-footer-socials">
                    <?php if ( $instagram ) : ?><a target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( $instagram ); ?>" aria-label="اینستاگرام"><?php vt_icon( 'instagram' ); ?></a><?php endif; ?>
                    <?php if ( $whatsapp ) : ?><a target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" aria-label="واتساپ">WA</a><?php endif; ?>
                </div>
            </div>
            <div class="vt-footer-column"><h3>دسترسی سریع</h3><a href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات</a><a href="<?php echo esc_url( vt_account_url() ); ?>">حساب کاربری</a><a href="<?php echo esc_url( vt_cart_url() ); ?>">سبد خرید</a></div>
            <div class="vt-footer-column"><h3>دسته‌بندی‌ها</h3><a href="<?php echo esc_url( vt_category_url( 'helmets' ) ); ?>">کلاه آفرود</a><a href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>">شیلد و عینک</a><a href="<?php echo esc_url( vt_category_url( 'gloves' ) ); ?>">دستکش موتور</a><a href="<?php echo esc_url( vt_category_url( 'armor' ) ); ?>">تجهیزات ایمنی</a></div>
            <div class="vt-footer-column"><h3>ارتباط با فروشگاه</h3>
                <?php if ( $phone ) : ?><a dir="ltr" class="vt-ltr" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
                <?php if ( $address ) : ?><p><?php echo nl2br( esc_html( $address ) ); ?></p><?php endif; ?>
                <?php if ( ! $phone && ! $address ) : ?><p>اطلاعات تماس از بخش «نمایش ← سفارشی‌سازی» قابل تنظیم است.</p><?php endif; ?>
            </div>
        </div>
        <div class="vt-footer-bottom"><span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> وحید تیونینگ. تمامی حقوق محفوظ است.</span><span class="vt-footer-mark">برای مسیرهای خاکی ساخته شده</span></div>
    </div>
</footer>
<?php wp_footer(); ?>
</body></html>
