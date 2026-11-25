<?php
/** Home storefront — "Night Trail" design. @package MotoVahid */
get_header();

$hero_title = get_theme_mod( 'vt_hero_title', VT_HERO_TITLE );
$category_catalog = vt_catalog_categories();
$products = vt_home_products();
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'vt_whatsapp', '' ) );
$ticker = array( 'تریل', 'اندرو', 'آفرود' );
foreach ( $category_catalog as $category ) { $ticker[] = $category['name']; }
?>
<main id="main-content" class="vt-home nt-home">
    <section class="nt-hero" aria-labelledby="vt-home-title">
        <div class="nt-hero-media" aria-hidden="true">
            <img src="<?php echo esc_url( vt_image_url( 'enduro-hero.jpg' ) ); ?>" alt="" width="1536" height="1024" fetchpriority="high">
        </div>
        <span class="nt-topo" aria-hidden="true"></span>
        <span class="nt-hero-watermark" aria-hidden="true" lang="en" dir="ltr">ENDURO</span>
        <div class="vt-container nt-hero-inner">
            <div class="nt-hero-copy">
                <p class="nt-kicker" data-reveal><span class="nt-plate" lang="en" dir="ltr">VT</span> تجهیزات تریل، اندرو و آفرود</p>
                <h1 id="vt-home-title" data-reveal><?php if ( VT_HERO_TITLE === $hero_title ) : ?><span>آمادهٔ مسیرهای</span><em>فراتر از جاده</em><?php else : ?><?php echo esc_html( $hero_title ); ?><?php endif; ?></h1>
                <p class="nt-hero-lead" data-reveal><?php echo esc_html( get_theme_mod( 'vt_hero_description', VT_HERO_DESCRIPTION ) ); ?></p>
                <div class="nt-actions" data-reveal>
                    <a class="nt-btn" href="<?php echo esc_url( vt_shop_url() ); ?>"><span>مشاهده محصولات</span> <?php vt_icon( 'arrow' ); ?></a>
                    <a class="nt-btn nt-btn-ghost" href="#vt-categories">مرور دسته‌بندی‌ها</a>
                </div>
            </div>
        </div>
        <a class="nt-scroll-cue" href="#vt-categories" aria-label="رفتن به دسته‌بندی‌ها"><span></span></a>
    </section>

    <div class="nt-ticker" aria-hidden="true">
        <div class="nt-ticker-track">
            <?php for ( $loop = 0; $loop < 2; $loop++ ) : ?>
                <div class="nt-ticker-group">
                    <?php foreach ( $ticker as $word ) : ?><span><?php echo esc_html( $word ); ?></span><i></i><?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <section class="nt-section nt-trust" aria-label="خدمات فروشگاه">
        <div class="vt-container">
            <ul class="nt-trust-list">
                <li data-reveal>
                    <span class="nt-trust-num" aria-hidden="true" dir="ltr">01</span>
                    <span class="nt-trust-icon"><?php vt_icon( 'shield' ); ?></span>
                    <span><strong>تجهیزات تخصصی</strong><small>مخصوص تریل، اندرو و آفرود</small></span>
                </li>
                <li data-reveal>
                    <span class="nt-trust-num" aria-hidden="true" dir="ltr">02</span>
                    <span class="nt-trust-icon"><?php vt_icon( 'truck' ); ?></span>
                    <span><strong>ارسال سفارش</strong><small>جزئیات ارسال در مرحله تسویه‌حساب</small></span>
                </li>
                <li data-reveal>
                    <a href="<?php echo esc_url( vt_account_url() ); ?>">
                        <span class="nt-trust-num" aria-hidden="true" dir="ltr">03</span>
                        <span class="nt-trust-icon"><?php vt_icon( 'support' ); ?></span>
                        <span><strong>پیگیری سفارش</strong><small>از بخش حساب کاربری</small></span>
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <section class="nt-section nt-categories" id="vt-categories" aria-labelledby="vt-category-title">
        <div class="vt-container">
            <div class="nt-head" data-reveal>
                <div><p class="nt-eyebrow">خرید بر اساس دسته‌بندی</p><h2 id="vt-category-title">تجهیزات برای هر مسیر</h2></div>
                <a class="nt-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همهٔ محصولات <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <div class="nt-bento">
                <?php $category_index = 0; foreach ( $category_catalog as $slug => $category ) : $category_index++; ?>
                    <a class="nt-tile nt-tile-<?php echo esc_attr( $category_index ); ?>" href="<?php echo esc_url( vt_category_url( $slug ) ); ?>" data-reveal>
                        <span class="nt-tile-image"><img src="<?php echo esc_url( vt_image_url( str_replace( array( 'category-', '.jpg' ), array( 'cutout-', '.webp' ), $category['image'] ) ) ); ?>" alt="" width="512" height="512" loading="lazy"></span>
                        <span class="nt-tile-copy">
                            <strong><?php echo esc_html( $category['name'] ); ?></strong>
                            <span>مشاهده محصولات <?php vt_icon( 'arrow' ); ?></span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part( 'template-parts/home', 'sale' ); ?>

    <section class="nt-section nt-products vt-home-products" aria-labelledby="vt-products-title">
        <span class="nt-topo nt-topo-soft" aria-hidden="true"></span>
        <div class="vt-container">
            <div class="nt-head" data-reveal>
                <div><p class="nt-eyebrow">محصولات فروشگاه</p><h2 id="vt-products-title">تجهیزات برای مسیر بعدی</h2></div>
                <a class="nt-link" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده فروشگاه <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <?php if ( $products ) : ?>
                <?php $featured_products = new WP_Query( array( 'post_type' => 'product', 'post__in' => $products, 'orderby' => 'post__in', 'posts_per_page' => count( $products ), 'no_found_rows' => true ) ); ?>
                <ul class="products vt-product-grid columns-4">
                    <?php while ( $featured_products->have_posts() ) : $featured_products->the_post(); wc_get_template_part( 'content', 'product' ); endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="vt-empty-products"><span class="vt-empty-icon"><?php vt_icon( 'bag' ); ?></span><div><strong>هنوز محصولی در فروشگاه نیست</strong><p>برای مشاهدهٔ محصولات بعداً دوباره سر بزنید.</p></div></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="nt-section nt-collections" aria-labelledby="vt-collections-title">
        <div class="vt-container">
            <div class="nt-head" data-reveal>
                <div><p class="nt-eyebrow">تجهیزات آفرود</p><h2 id="vt-collections-title">تجهیزات راکب و موتور</h2></div>
                <a class="nt-link" href="<?php echo esc_url( vt_shop_url() ); ?>">همهٔ تجهیزات <?php vt_icon( 'arrow' ); ?></a>
            </div>
            <div class="nt-collection-grid">
                <a class="nt-collection nt-collection-main" href="<?php echo esc_url( vt_category_url( 'helmets' ) ); ?>" data-reveal>
                    <span class="nt-collection-copy"><small>تجهیزات راکب</small><strong>کلاه کاسکت</strong><span>کلاه کاسکت برای سواری در مسیرهای خاکی</span><b>دیدن کلاه‌ها <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'cutout-helmet.webp' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
                <a class="nt-collection" href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>" data-reveal>
                    <span class="nt-collection-copy"><small>دید و محافظت</small><strong>عینک و شیلد</strong><b>مشاهده <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'cutout-goggles.webp' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
                <a class="nt-collection" href="<?php echo esc_url( vt_category_url( 'parts' ) ); ?>" data-reveal>
                    <span class="nt-collection-copy"><small>برای موتور</small><strong>قطعات و لوازم</strong><b>مشاهده <?php vt_icon( 'arrow' ); ?></b></span>
                    <img src="<?php echo esc_url( vt_image_url( 'cutout-parts.webp' ) ); ?>" alt="" width="512" height="512" loading="lazy">
                </a>
            </div>
        </div>
    </section>

    <section class="nt-finish" aria-labelledby="vt-finish-title">
        <img class="nt-finish-image" src="<?php echo esc_url( vt_image_url( 'enduro-hero.jpg' ) ); ?>" alt="" width="1536" height="1024" loading="lazy">
        <div class="nt-finish-flag" aria-hidden="true"></div>
        <div class="vt-container nt-finish-inner" data-reveal>
            <div><p class="nt-eyebrow">موتو وحید</p><h2 id="vt-finish-title">برای مسیر بعدی آماده شوید</h2><p>تجهیزات تریل، اندرو و آفرود را در فروشگاه ببینید.</p></div>
            <div class="nt-actions">
                <a class="nt-btn" href="<?php echo esc_url( vt_shop_url() ); ?>"><span>ورود به فروشگاه</span> <?php vt_icon( 'arrow' ); ?></a>
                <?php if ( $whatsapp ) : ?><a class="nt-btn nt-btn-ghost" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>">گفت‌وگو در واتساپ</a><?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
