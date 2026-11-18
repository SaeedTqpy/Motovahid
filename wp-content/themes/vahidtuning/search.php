<?php
/** Search fallback for posts and products. */
get_header(); ?>
<main id="main-content" class="vt-page vt-container">
<h1>نتایج جستجو برای «<?php echo esc_html( get_search_query() ); ?>»</h1>
<?php if ( have_posts() ) : ?>
    <div class="vt-search-results">
    <?php while ( have_posts() ) : the_post(); ?>
        <article class="vt-search-result"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p></article>
    <?php endwhile; ?>
    </div><?php the_posts_pagination(); ?>
<?php else : ?><div class="vt-empty-products">محصول یا نوشته‌ای مطابق جستجوی شما پیدا نشد.</div><?php endif; ?>
</main>
<?php get_footer(); ?>
