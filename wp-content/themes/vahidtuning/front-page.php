<?php
/** Home storefront. @package VahidTuning */
get_header();

$hero_title = get_theme_mod( 'vt_hero_title', VT_HERO_TITLE );
$category_catalog = vt_catalog_categories();
$products = vt_home_products();
$category_count = count( $category_catalog );
$product_count = vt_has_woocommerce() ? (int) wp_count_posts( 'product' )->publish : 0;
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'vt_whatsapp', '' ) );
?>
<main id="main-content" class="vt-home">
    <section class="vt-home-hero" aria-labelledby="vt-home-title">
        <img class="vt-home-hero-image" src="<?php echo esc_url( vt_image_url( 'enduro-hero.jpg' ) ); ?>" alt="" width="1536" height="1024" fetchpriority="high">
        <div class="vt-container vt-home-hero-inner">
            <div class="vt-home-hero-copy">
                <p class="vt-home-kicker"><i aria-hidden="true"></i> تجهیزات تریل، اندرو و آفرود</p>
                <h1 id="vt-home-title"><?php if ( VT_HERO_TITLE === $hero_title ) : ?>برای مسیرهای<br><em>خارج از جاده</em><?php else : ?><?php echo esc_html( $hero_title ); ?><?php endif; ?></h1>
                <p class="vt-home-hero-description"><?php echo esc_html( get_theme_mod( 'vt_hero_description', VT_HERO_DESCRIPTION ) ); ?></p>
                <div class="vt-home-actions">
                    <a class="vt-home-button" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده تجهیزات <?php vt_icon( 'arrow' ); ?></a>
                    <a class="vt-home-button vt-home-button-ghost" href="#vt-categories">دسته‌بندی‌ها</a>
                </div>
                <ul class="vt-home-hero-stats">
                    <li><strong><?php echo esc_html( vt_format_number( $category_count ) ); ?></strong><span>دستهٔ تخصصی</span></li>
                    <?php if ( $product_count > 0 ) : ?>
                        <li><strong><?php echo esc_html( vt_format_number( $product_count ) ); ?></strong><span>محصول در فروشگاه</span></li>
                    <?php endif; ?>
                    <li><strong>تریل · اندرو</strong><span>و مسیرهای خاکی</span></li>
                </ul>
            </div>
        </div>
    </section>

    <div class="vt-home-trust">
        <div class="vt-container">
            <ul class="vt-home-trust-list">
                <li>
                    <div class="vt-home-trust-item">
                        <span class="vt-home-trust-icon"><?php vt_icon( 'shield' ); ?></span>
                        <span><strong>تجهیزات تخصصی</strong><small>مخصوص تریل، اندرو و آفرود</small></span>
                    </div>
                </li>
                <li>
                    <div class="vt-home-trust-item">
                        <span class="vt-home-trust-icon"><?php vt_icon( 'truck' ); ?></span>
                        <span><strong>ارسال سفارش</strong><small>جزئیات ارسال در مرحله تسویه‌حساب</small></span>
                    </div>
                </li>
                <li>
                    <a class="vt-home-trust-item" href="<?php echo esc_url( vt_account_url() ); ?>">
                        <span class="vt-home-trust-icon"><?php vt_icon( 'support' ); ?></span>
                        <span><strong>پیگیری سفارش</strong><small>از بخش حساب کاربری</small></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <section class="vt-home-categories" id="vt-categories" aria-labelledby="vt-category-title">
        <div class="vt-container">
            <div class="vt-home-section-head">
                <div><p class="vt-home-eyebrow">تجهیزات مسیر</p><h2 id="vt-category-title">برای هر بخش از مسیر</h2></div>
                <a class="vt-home-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <div class="vt-home-category-grid">
                <?php $category_index = 0; foreach ( $category_catalog as $slug => $category ) : $category_index++; ?>
                    <a class="vt-home-category" href="<?php echo esc_url( vt_category_url( $slug ) ); ?>">
                        <span class="vt-home-category-text">
                            <span class="vt-home-category-index" aria-hidden="true"><?php echo esc_html( vt_format_number( sprintf( '%02d', $category_index ) ) ); ?></span>
                            <strong><?php echo esc_html( $category['name'] ); ?></strong>
                            <span class="vt-home-category-action">مشاهده محصولات <?php vt_icon( 'arrow' ); ?></span>
                        </span>
                        <span class="vt-home-category-image"><img src="<?php echo esc_url( vt_image_url( $category['image'] ) ); ?>" alt="" width="512" height="512" loading="lazy"></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="vt-home-products" aria-labelledby="vt-products-title">
        <div class="vt-container">
            <div class="vt-home-section-head">
                <div><p class="vt-home-eyebrow">منتخب فروشگاه</p><h2 id="vt-products-title">تجهیزات برای مسیر بعدی</h2></div>
                <a class="vt-home-link" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده فروشگاه <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <?php if ( $products ) : ?>
                <?php $featured_products = new WP_Query( array( 'post_type' => 'product', 'post__in' => $products, 'orderby' => 'post__in', 'posts_per_page' => count( $products ), 'no_found_rows' => true ) ); ?>
                <ul class="products vt-product-grid columns-4">
                    <?php while ( $featured_products->have_posts() ) : $featured_products->the_post(); wc_get_template_part( 'content', 'product' ); endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="vt-empty-products"><span class="vt-empty-icon"><?php vt_icon( 'bag' ); ?></span><div><strong>محصولات به‌زودی اضافه می‌شوند</strong><p>در حال حاضر محصولی برای خرید در فروشگاه ثبت نشده است.</p></div></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="vt-home-collections" aria-labelledby="vt-collections-title">
        <div class="vt-container">
            <div class="vt-home-section-head">
                <div><p class="vt-home-eyebrow">تجهیزات آفرود</p><h2 id="vt-collections-title">برای راکب و موتور</h2></div>
                <a class="vt-home-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همه تجهیزات <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <div class="vt-home-collection-grid">
                <a class="vt-collection vt-collection-helmet" href="<?php echo esc_url( vt_category_url( 'helmets' ) ); ?>">
                    <span class="vt-collection-copy"><small>تجهیزات راکب</small><strong>آمادهٔ مسیر شو</strong><span>کلاه کاسکت برای سواری در مسیرهای خاکی</span><b>دیدن کلاه‌ها <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'category-helmet.jpg' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
                <a class="vt-collection vt-collection-goggles" href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>">
                    <span class="vt-collection-copy"><small>دید و محافظت</small><strong>عینک و شیلد</strong><b>مشاهده <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'category-goggles.jpg' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
                <a class="vt-collection vt-collection-parts" href="<?php echo esc_url( vt_category_url( 'parts' ) ); ?>">
                    <span class="vt-collection-copy"><small>برای موتور</small><strong>قطعات و لوازم</strong><b>مشاهده <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'category-parts.jpg' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
            </div>
        </div>
    </section>

    <section class="vt-home-ending">
        <img class="vt-home-ending-image" src="<?php echo esc_url( vt_image_url( 'enduro-hero.jpg' ) ); ?>" alt="" width="1536" height="1024" loading="lazy">
        <div class="vt-container vt-home-ending-inner">
            <div><p class="vt-home-eyebrow">وحید تیونینگ</p><h2>مسیر بعدی منتظرته.</h2><p>تجهیزات تریل، اندرو و آفرود را در فروشگاه ببین.</p></div>
            <div class="vt-home-actions">
                <a class="vt-home-button" href="<?php echo esc_url( vt_shop_url() ); ?>">ورود به فروشگاه <?php vt_icon( 'arrow' ); ?></a>
                <?php if ( $whatsapp ) : ?><a class="vt-home-button vt-home-button-ghost" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>">گفتگو در واتساپ</a><?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
