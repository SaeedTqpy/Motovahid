<?php
/** Home storefront. @package VahidTuning */
get_header();

$hero_title = get_theme_mod( 'vt_hero_title', VT_HERO_TITLE );
$category_catalog = vt_catalog_categories();
$products = vt_home_products();
?>
<main id="main-content" class="vt-home">
    <section class="vt-home-hero" aria-labelledby="vt-home-title">
        <img class="vt-home-hero-image" src="<?php echo esc_url( vt_image_url( 'enduro-hero.jpg' ) ); ?>" alt="" width="1536" height="1024" fetchpriority="high">
        <div class="vt-container vt-home-hero-inner">
            <div class="vt-home-hero-copy">
                <p class="vt-home-kicker">تجهیزات تریل و اندرو</p>
                <h1 id="vt-home-title"><?php if ( VT_HERO_TITLE === $hero_title ) : ?>برای مسیرهای<br><em>خارج از جاده</em><?php else : ?><?php echo esc_html( $hero_title ); ?><?php endif; ?></h1>
                <p class="vt-home-hero-description"><?php echo esc_html( get_theme_mod( 'vt_hero_description', VT_HERO_DESCRIPTION ) ); ?></p>
                <a class="vt-home-button" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده تجهیزات <?php vt_icon( 'arrow' ); ?></a>
            </div>
        </div>
    </section>

    <div class="vt-home-service-bar">
        <div class="vt-container">
            <span><?php vt_icon( 'shield' ); ?> تجهیزات تخصصی تریل و اندرو</span>
            <span><?php vt_icon( 'truck' ); ?> جزئیات ارسال در تسویه‌حساب</span>
            <a href="<?php echo esc_url( vt_account_url() ); ?>"><?php vt_icon( 'support' ); ?> پیگیری سفارش</a>
        </div>
    </div>

    <section class="vt-home-categories" id="vt-categories" aria-labelledby="vt-category-title">
        <div class="vt-container">
            <div class="vt-home-section-head">
                <div><p class="vt-home-eyebrow">تجهیزات مسیر</p><h2 id="vt-category-title">برای هر بخش از مسیر</h2></div>
                <a class="vt-home-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <div class="vt-home-category-grid">
                <?php foreach ( $category_catalog as $slug => $category ) : ?>
                    <a class="vt-home-category" href="<?php echo esc_url( vt_category_url( $slug ) ); ?>">
                        <span class="vt-home-category-image"><img src="<?php echo esc_url( vt_image_url( $category['image'] ) ); ?>" alt="" width="512" height="512" loading="lazy"></span>
                        <strong><?php echo esc_html( $category['name'] ); ?></strong>
                        <span class="vt-home-category-action">مشاهده محصولات <?php vt_icon( 'arrow' ); ?></span>
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
        <div class="vt-container vt-home-ending-inner">
            <div><p class="vt-home-eyebrow">وحید تیونینگ</p><h2>مسیر بعدی منتظرته.</h2><p>تجهیزات تریل، اندرو و آفرود را در فروشگاه ببین.</p></div>
            <a class="vt-home-button" href="<?php echo esc_url( vt_shop_url() ); ?>">ورود به فروشگاه <?php vt_icon( 'arrow' ); ?></a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
