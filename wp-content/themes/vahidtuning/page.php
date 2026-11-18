<?php
/** Content page / WooCommerce cart and checkout blocks. */
get_header(); ?>
<main id="main-content" class="vt-page vt-container">
<?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class( 'vt-entry' ); ?>>
        <div class="vt-page-head"><p class="vt-section-overline"><span></span> VAHID TUNING</p><h1><?php the_title(); ?></h1></div>
        <div class="vt-entry-content"><?php the_content(); ?></div>
    </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
