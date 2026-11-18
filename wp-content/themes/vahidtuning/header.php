<?php
/** Site header. @package VahidTuning */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="vt-skip-link" href="#main-content">رفتن به محتوای اصلی</a>
<div class="vt-announcement"><div class="vt-container"><span class="vt-announcement-dot"></span><?php echo esc_html( get_theme_mod( 'vt_announcement', 'آماده برای مسیرهای سخت؛ خرید آسان تجهیزات آفرود' ) ); ?><span class="vt-announcement-end">فروشگاه تخصصی تجهیزات تریل و آفرود</span></div></div>
<header class="vt-header" id="vt-header">
    <div class="vt-container vt-header-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vt-brand" aria-label="وحید تیونینگ، صفحه اصلی">
            <span class="vt-brand-symbol"><span>V</span><i></i></span>
            <span class="vt-brand-copy"><strong>وحید تیونینگ</strong><small>تجهیزات موتور تریل و آفرود</small></span>
        </a>
        <nav class="vt-desktop-nav" aria-label="ناوبری اصلی">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'vt-menu', 'depth' => 2 ) ); ?>
            <?php else : ?>
            <ul class="vt-menu">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a></li>
                <li><a href="<?php echo esc_url( vt_shop_url() ); ?>">فروشگاه</a></li>
                <li><a href="<?php echo esc_url( vt_category_url( 'helmets' ) ); ?>">کلاه کاسکت</a></li>
                <li><a href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>">عینک و شیلد</a></li>
                <li><a href="<?php echo esc_url( vt_category_url( 'gloves' ) ); ?>">دستکش</a></li>
                <li><a href="<?php echo esc_url( vt_category_url( 'parts' ) ); ?>">لوازم فنی</a></li>
            </ul>
            <?php endif; ?>
        </nav>
        <div class="vt-header-actions">
            <button class="vt-icon-btn vt-search-trigger" type="button" data-vt-search-toggle aria-label="بازکردن جستجو" aria-expanded="false"><?php vt_icon( 'search' ); ?></button>
            <a class="vt-icon-btn vt-account-link" href="<?php echo esc_url( vt_account_url() ); ?>" aria-label="حساب کاربری"><?php vt_icon( 'user' ); ?></a>
            <a class="vt-icon-btn vt-cart-link" href="<?php echo esc_url( vt_cart_url() ); ?>" aria-label="سبد خرید"><?php vt_icon( 'bag' ); ?><span class="vt-cart-count"><?php echo esc_html( (string) vt_cart_count() ); ?></span></a>
            <button class="vt-icon-btn vt-mobile-menu-trigger" type="button" data-vt-menu-toggle aria-expanded="false" aria-controls="vt-mobile-navigation" aria-label="بازکردن منو"><?php vt_icon( 'menu' ); ?></button>
        </div>
    </div>
    <div class="vt-search-panel" id="vt-search-panel" hidden>
        <form method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="vt-container vt-search-form">
            <label for="vt-search-field"><?php vt_icon( 'search' ); ?><span class="screen-reader-text">جستجوی محصولات</span></label>
            <input id="vt-search-field" type="search" name="s" placeholder="دنبال چه تجهیزاتی می‌گردی؟" value="<?php echo esc_attr( get_search_query() ); ?>">
            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="vt-btn vt-btn-primary">جستجو</button>
        </form>
    </div>
    <nav class="vt-mobile-navigation" id="vt-mobile-navigation" aria-label="منوی موبایل" hidden>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
        <a href="<?php echo esc_url( vt_shop_url() ); ?>">همه محصولات</a>
        <a href="<?php echo esc_url( vt_category_url( 'helmets' ) ); ?>">کلاه کاسکت</a>
        <a href="<?php echo esc_url( vt_category_url( 'goggles' ) ); ?>">عینک و شیلد</a>
        <a href="<?php echo esc_url( vt_category_url( 'gloves' ) ); ?>">دستکش</a>
        <a href="<?php echo esc_url( vt_category_url( 'boots' ) ); ?>">بوت و پوشاک</a>
        <a href="<?php echo esc_url( vt_category_url( 'armor' ) ); ?>">تجهیزات ایمنی</a>
        <a href="<?php echo esc_url( vt_category_url( 'parts' ) ); ?>">قطعات و لوازم فنی</a>
    </nav>
</header>
