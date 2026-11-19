<?php
/** Store header. @package VahidTuning */
defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html lang="fa" dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="vt-skip-link" href="#main-content">رفتن به محتوای اصلی</a>
<div class="vt-announcement">
    <div class="vt-container">
        <span><?php echo esc_html( get_theme_mod( 'vt_announcement', VT_ANNOUNCEMENT ) ); ?></span>
        <span class="vt-top-label" lang="en" dir="ltr"><i></i> ENDURO &amp; OFF-ROAD</span>
    </div>
</div>
<header class="vt-header" id="vt-header">
    <div class="vt-container vt-header-inner">
        <?php vt_brand(); ?>
        <form method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="vt-search-form">
            <label class="screen-reader-text" for="vt-search-field">جستجوی محصولات</label>
            <input id="vt-search-field" type="search" name="s" required placeholder="جستجو در تجهیزات، مدل یا قطعه…" value="<?php echo esc_attr( get_search_query( false ) ); ?>">
            <?php if ( vt_has_woocommerce() ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
            <button type="submit" aria-label="جستجو"><?php vt_icon( 'search' ); ?></button>
        </form>
        <div class="vt-header-actions">
            <a class="vt-icon-btn vt-account-link" href="<?php echo esc_url( vt_account_url() ); ?>"><?php vt_icon( 'user' ); ?><span>حساب کاربری</span></a>
            <a class="vt-icon-btn vt-cart-link" href="<?php echo esc_url( vt_cart_url() ); ?>">
                <?php vt_icon( 'bag' ); ?><span class="vt-cart-label">سبد خرید</span>
                <span class="vt-cart-count"><?php echo esc_html( vt_format_number( vt_cart_count() ) ); ?></span>
            </a>
            <button class="vt-icon-btn vt-mobile-menu-trigger" type="button" data-vt-menu-toggle aria-expanded="false" aria-controls="vt-store-nav" aria-label="منوی فروشگاه" hidden><?php vt_icon( 'menu' ); ?></button>
        </div>
    </div>
    <nav class="vt-store-nav" id="vt-store-nav" aria-label="منوی فروشگاه">
        <div class="vt-container vt-nav-inner">
            <a class="vt-nav-shop" href="<?php echo esc_url( vt_shop_url() ); ?>"<?php if ( function_exists( 'is_shop' ) && is_shop() ) : ?> aria-current="page"<?php endif; ?>><?php vt_icon( 'grid' ); ?> همه محصولات</a>
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'vt-menu', 'depth' => 2 ) ); ?>
            <?php else : ?>
                <ul class="vt-menu">
                    <?php foreach ( vt_catalog_categories() as $slug => $category ) : ?>
                        <li><a href="<?php echo esc_url( vt_category_url( $slug ) ); ?>"<?php if ( is_tax( 'product_cat', $slug ) ) : ?> aria-current="page"<?php endif; ?>><?php echo esc_html( $category['name'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
</header>
