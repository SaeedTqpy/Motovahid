<?php
/** Front page: designed for catalog growth, not hard-coded inventory. */
get_header();
$categories = array(
    array( 'slug' => 'helmets', 'name' => 'کلاه کاسکت', 'english' => 'HELMETS', 'number' => '01', 'art' => 'helmet.svg' ),
    array( 'slug' => 'goggles', 'name' => 'عینک و شیلد', 'english' => 'GOGGLES', 'number' => '02', 'art' => 'goggles.svg' ),
    array( 'slug' => 'gloves', 'name' => 'دستکش', 'english' => 'GLOVES', 'number' => '03', 'art' => 'gloves.svg' ),
    array( 'slug' => 'boots', 'name' => 'بوت و پوشاک', 'english' => 'BOOTS', 'number' => '04', 'art' => 'boots.svg' ),
    array( 'slug' => 'armor', 'name' => 'تجهیزات ایمنی', 'english' => 'PROTECTION', 'number' => '05', 'art' => 'armor.svg' ),
    array( 'slug' => 'parts', 'name' => 'قطعات و لوازم', 'english' => 'PARTS', 'number' => '06', 'art' => 'parts.svg' ),
);
?>
<main id="main-content">
<section class="vt-hero">
    <div class="vt-hero-noise" aria-hidden="true"></div>
    <div class="vt-container vt-hero-grid">
        <div class="vt-hero-content">
            <div class="vt-eyebrow"><span></span> EST. 2026 / TRAIL & ENDURO EQUIPMENT</div>
            <p class="vt-hero-kicker">فروشگاه تخصصی تجهیزات موتور تریل</p>
            <h1><?php echo esc_html( get_theme_mod( 'vt_hero_title', 'برای مسیرهایی که پایان ندارند' ) ); ?><em>.</em></h1>
            <p class="vt-hero-desc"><?php echo esc_html( get_theme_mod( 'vt_hero_description', 'تجهیزات تخصصی موتور تریل، اندرو و آفرود؛ انتخاب‌های جسورانه برای ماجراجویی امن‌تر.' ) ); ?></p>
            <div class="vt-hero-ctas"><a class="vt-btn vt-btn-acid" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده تجهیزات <?php vt_icon( 'arrow' ); ?></a><a href="#vt-categories" class="vt-text-link">کاوش دسته‌بندی‌ها <span>↙</span></a></div>
            <div class="vt-hero-footnote"><span class="vt-hero-line"></span><span>RIDE FURTHER. / STAY READY.</span></div>
        </div>
        <div class="vt-hero-visual" aria-hidden="true">
            <div class="vt-hero-orbit orbit-a"></div><div class="vt-hero-orbit orbit-b"></div>
            <span class="vt-hero-serial">V / T • PERFORMANCE DIVISION</span>
            <span class="vt-hero-oversized">OFF<br>ROAD</span>
            <img class="vt-hero-product" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/helmet.svg' ); ?>" alt="" width="600" height="600" fetchpriority="high">
            <div class="vt-hero-index"><span>01 / 06</span><span>ENGINEERED FOR ADVENTURE</span></div>
        </div>
    </div>
    <div class="vt-hero-bottom"><div class="vt-container"><span>THE ROAD ENDS. THE RIDE DOESN'T.</span><span>اسکرول کن و تجهیزاتت رو پیدا کن ↓</span></div></div>
</section>
<section class="vt-benefits" aria-label="مزیت‌های فروشگاه"><div class="vt-container vt-benefits-grid">
    <div><?php vt_icon( 'shield' ); ?><span><strong>تجهیزات تخصصی</strong><small>انتخاب مناسب تریل و اندرو</small></span></div>
    <div><?php vt_icon( 'truck' ); ?><span><strong>ارسال سفارش</strong><small>جزئیات هنگام ثبت سفارش</small></span></div>
    <div><?php vt_icon( 'support' ); ?><span><strong>راهنمایی خرید</strong><small>انتخاب مناسب سبک سواری</small></span></div>
</div></section>
<section class="vt-section vt-categories-section" id="vt-categories"><div class="vt-container">
    <div class="vt-section-heading"><div><p class="vt-section-overline"><span></span> EXPLORE THE GEAR / 01</p><h2>برای هر مسیر، <span>یک انتخاب.</span></h2><p>از حفاظت سر تا تجهیزات فنی؛ هر آنچه برای یک سواری آماده نیاز داری.</p></div><a class="vt-text-link vt-section-link" href="<?php echo esc_url( vt_shop_url() ); ?>">تمام محصولات <?php vt_icon( 'arrow' ); ?></a></div>
    <div class="vt-category-grid">
    <?php foreach ( $categories as $category ) : ?>
      <a class="vt-category-card" href="<?php echo esc_url( vt_category_url( $category['slug'] ) ); ?>">
        <span class="vt-category-number"><?php echo esc_html( $category['number'] ); ?> / 06</span>
        <img loading="lazy" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $category['art'] ); ?>" alt="" width="230" height="200">
        <span class="vt-category-text"><strong><?php echo esc_html( $category['name'] ); ?></strong><small><?php echo esc_html( $category['english'] ); ?></small></span><span class="vt-category-arrow"><?php vt_icon( 'arrow' ); ?></span>
      </a>
    <?php endforeach; ?>
    </div>
</div></section>
<section class="vt-section vt-products-section"><div class="vt-container">
    <div class="vt-section-heading"><div><p class="vt-section-overline"><span></span> CURATED SELECTION / 02</p><h2>تجهیزات <span>پیشنهادی.</span></h2><p>منتخب فروشگاه برای شروع یک ماجراجویی تازه.</p></div><a class="vt-text-link vt-section-link" href="<?php echo esc_url( vt_shop_url() ); ?>">ورود به فروشگاه <?php vt_icon( 'arrow' ); ?></a></div>
    <?php if ( vt_has_woocommerce() ) : ?>
        <?php
        $featured_products = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 6, 'tax_query' => array( array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => array( 'exclude-from-catalog' ), 'operator' => 'NOT IN' ) ) ) );
        if ( $featured_products->have_posts() ) : ?>
        <ul class="products vt-product-grid columns-3">
            <?php while ( $featured_products->have_posts() ) : $featured_products->the_post(); wc_get_template_part( 'content', 'product' ); endwhile; ?>
        </ul>
        <?php else : ?>
            <div class="vt-empty-products"><strong>تجهیزات در راه‌اند.</strong><p>پس از فعال‌سازی ووکامرس می‌توانید محصولات نمونه را از ابزارهای وردپرس وارد کنید.</p></div>
        <?php endif; wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="vt-empty-products"><strong>فروشگاه آماده اتصال به ووکامرس است.</strong><p>افزونه WooCommerce را فعال کنید تا محصولات در همین بخش نمایش داده شوند.</p></div>
    <?php endif; ?>
</div></section>
<section class="vt-promo"><div class="vt-container vt-promo-inner">
    <div class="vt-promo-art"><span>DIRT / MODE</span><img loading="lazy" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/goggles.svg' ); ?>" alt="" width="400" height="300"></div>
    <div class="vt-promo-copy"><p class="vt-section-overline"><span></span> VISION WITHOUT LIMITS</p><h2>دیدت رو باز کن.<br><em>محدودیت رو نه.</em></h2><p>عینک، شیلد و تجهیزات محافظتی برای زمانی که مسیر، حرف آخر رو می‌زنه.</p><a class="vt-btn vt-btn-dark" href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>">دیدن عینک و شیلد <?php vt_icon( 'arrow' ); ?></a></div>
</div></section>
<section class="vt-section vt-last-section"><div class="vt-container vt-last-inner"><div><p class="vt-section-overline"><span></span> RIDE YOUR OWN LINE</p><h2>جاده تموم می‌شه.<br><span>ماجراجویی نه.</span></h2></div><a class="vt-btn vt-btn-primary" href="<?php echo esc_url( vt_shop_url() ); ?>">تجهیزات مسیر بعدی <?php vt_icon( 'arrow' ); ?></a></div></section>
</main>
<?php get_footer(); ?>
