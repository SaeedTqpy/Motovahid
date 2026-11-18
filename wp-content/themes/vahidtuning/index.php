<?php
/** Generic page / posts fallback. */
get_header(); ?>
<main id="main-content" class="vt-page vt-container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article <?php post_class( 'vt-entry' ); ?>><h1><?php the_title(); ?></h1><div class="vt-entry-content"><?php the_content(); ?></div></article>
    <?php endwhile; the_posts_pagination(); else : ?>
        <div class="vt-empty-products"><h1>محتوایی پیدا نشد</h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>">بازگشت به خانه</a></div>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
