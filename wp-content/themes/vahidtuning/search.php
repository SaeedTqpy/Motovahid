<?php
/** Search results, with native WooCommerce purchase cards for product searches. */
get_header();
$is_product_search = vt_has_woocommerce() && ( 'product' === get_query_var( 'post_type' ) || ( isset( $_GET['post_type'] ) && 'product' === sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) ) );
?>
<main id="main-content" class="vt-page vt-container">
    <div class="vt-page-head">
        <p class="vt-section-overline"><span></span> جستجوی فروشگاه</p>
        <h1>نتایج جستجو برای «<?php echo esc_html( get_search_query() ); ?>»</h1>
    </div>
    <?php if ( have_posts() ) : ?>
        <?php if ( $is_product_search ) : ?>
            <ul class="products vt-product-grid columns-3">
                <?php while ( have_posts() ) : the_post(); wc_get_template_part( 'content', 'product' ); endwhile; ?>
            </ul>
        <?php else : ?>
            <div class="vt-search-results">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="vt-search-result">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <div class="vt-empty-products"><strong>چیزی پیدا نشد.</strong><p>عبارت دیگری را امتحان کن یا تجهیزات موجود را ببین.</p><a class="vt-btn vt-btn-primary" href="<?php echo esc_url( vt_shop_url() ); ?>">مشاهده فروشگاه</a></div>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
