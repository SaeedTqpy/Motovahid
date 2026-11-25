<?php
/** Localized WooCommerce purchase pages, including the Cart and Checkout blocks. */
defined( 'ABSPATH' ) || exit;

function vt_purchase_screen() {
    if ( ! function_exists( 'is_cart' ) ) { return ''; }
    if ( is_cart() ) { return 'cart'; }
    return is_checkout() && ! is_order_received_page() ? 'checkout' : '';
}

function vt_purchase_labels() {
    static $labels = array(
        'Cart' => 'سبد خرید',
        'Checkout' => 'تسویه‌حساب',
        'Payment' => 'پرداخت',
        'Cart totals' => 'خلاصهٔ سبد خرید',
        'Estimated total' => 'جمع سبد خرید',
        'Proceed to Checkout' => 'ادامه به تسویه‌حساب',
        'Proceed to checkout' => 'ادامه به تسویه‌حساب',
        'Finish checkout' => 'ادامه به تسویه‌حساب',
        'Continue shopping' => 'ادامه خرید',
        'Return to shop' => 'بازگشت به فروشگاه',
        'Return to Cart' => 'بازگشت به سبد خرید',
        'Back to cart' => 'بازگشت به سبد خرید',
        'Edit your cart' => 'ویرایش سبد خرید',
        'Products in cart' => 'محصولات سبد خرید',
        'Product' => 'محصول',
        'Products' => 'محصولات',
        'Details' => 'جزئیات محصول',
        'Price' => 'قیمت',
        'Quantity' => 'تعداد',
        'Subtotal' => 'جمع کالاها',
        'Subtotal:' => 'جمع کالاها:',
        'Total' => 'جمع کل',
        'Discount' => 'تخفیف',
        'Discount:' => 'تخفیف:',
        'Save %s' => '%s صرفه‌جویی',
        'Previous price:' => 'قیمت قبلی:',
        'Discounted price:' => 'قیمت با تخفیف:',
        'Remove' => 'حذف',
        'Remove item' => 'حذف کالا',
        'Remove %s' => 'حذف %s',
        'Remove %s from cart' => 'حذف %s از سبد خرید',
        'Reduce quantity of %s' => 'کاهش تعداد %s',
        'Increase quantity of %s' => 'افزایش تعداد %s',
        'Quantity of %s in your cart.' => 'تعداد %s در سبد خرید',
        'Quantity reduced to %s.' => 'تعداد به %s کاهش یافت.',
        'Quantity increased to %s.' => 'تعداد به %s افزایش یافت.',
        '%s has been removed from your cart.' => '%s از سبد خرید حذف شد.',
        '"%s" was removed from your cart.' => '«%s» از سبد خرید حذف شد.',
        'Undo' => 'برگرداندن',
        'Update cart' => 'به‌روزرسانی سبد خرید',
        'Cart updated.' => 'سبد خرید به‌روزرسانی شد.',
        'Your cart is empty' => 'سبد خرید خالی است',
        'Your cart is currently empty!' => 'سبد خرید خالی است.',
        'Your cart is currently empty.' => 'سبد خرید خالی است.',
        'New in store' => 'تازه‌های فروشگاه',
        'Add coupons' => 'کد تخفیف',
        'Add a coupon' => 'افزودن کد تخفیف',
        'Coupons' => 'کدهای تخفیف',
        'Coupon' => 'کد تخفیف',
        'Coupon: %s' => 'کد تخفیف: %s',
        'Coupon code' => 'کد تخفیف',
        'Enter code' => 'کد را وارد کنید',
        'Enter a coupon code' => 'کد تخفیف را وارد کنید',
        'Apply' => 'اعمال',
        'Apply coupon' => 'اعمال کد تخفیف',
        'Applying coupon…' => 'در حال اعمال کد تخفیف…',
        'Removing coupon…' => 'در حال حذف کد تخفیف…',
        'Remove coupon' => 'حذف کد تخفیف',
        'Remove coupon "%s"' => 'حذف کد تخفیف «%s»',
        'Coupon code applied successfully.' => 'کد تخفیف اعمال شد.',
        'Coupon code removed successfully.' => 'کد تخفیف حذف شد.',
        'Please enter a coupon code.' => 'کد تخفیف را وارد کنید.',
        'Shipping' => 'ارسال',
        'Shipping:' => 'ارسال:',
        'Shipping method' => 'روش ارسال',
        'Shipping options' => 'روش‌های ارسال',
        'Shipping options are not available' => 'روش ارسالی در دسترس نیست',
        'Shipping will be calculated at checkout' => 'هزینهٔ ارسال در تسویه‌حساب محاسبه می‌شود.',
        'Calculated at checkout' => 'در تسویه‌حساب محاسبه می‌شود',
        'calculated with an address' => 'پس از وارد کردن نشانی محاسبه می‌شود',
        'Enter address to calculate' => 'نشانی را برای محاسبه وارد کنید',
        'Enter a shipping address to view shipping options.' => 'نشانی ارسال را برای مشاهدهٔ روش‌های ارسال وارد کنید.',
        'No shipping options are available for this address. Please verify the address is correct or try a different address.' => 'برای این نشانی روشی برای ارسال وجود ندارد. نشانی را بررسی کنید یا نشانی دیگری وارد کنید.',
        'Flat rate shipping' => 'ارسال با نرخ ثابت',
        'Free shipping' => 'ارسال رایگان',
        'Local pickup' => 'تحویل حضوری',
        'Taxes' => 'مالیات',
        'Taxes:' => 'مالیات:',
        'Including <TaxAmount/> in taxes' => 'شامل <TaxAmount/> مالیات',
        'Contact information' => 'اطلاعات تماس',
        'Email address' => 'نشانی ایمیل',
        'You are currently checking out as a guest.' => 'در حال خرید به‌عنوان مهمان هستید.',
        'Log in' => 'ورود',
        'Already have an account?' => 'حساب کاربری دارید؟',
        'Create an account?' => 'حساب کاربری بسازید؟',
        'Create an account with %s' => 'ساخت حساب کاربری در %s',
        'Create a password' => 'ایجاد رمز عبور',
        'Password' => 'رمز عبور',
        'Billing details' => 'اطلاعات صورتحساب',
        'Billing address' => 'نشانی صورتحساب',
        'Shipping address' => 'نشانی ارسال',
        'Billing and shipping address' => 'نشانی ارسال و صورتحساب',
        'Enter the billing and shipping address that matches your payment method.' => 'نشانی مربوط به ارسال و صورتحساب را وارد کنید.',
        'Use same address for billing' => 'از همین نشانی برای صورتحساب استفاده شود',
        'Ship to a different address?' => 'به نشانی دیگری ارسال شود؟',
        'Edit shipping address' => 'ویرایش نشانی ارسال',
        'Edit billing address' => 'ویرایش نشانی صورتحساب',
        'First name' => 'نام',
        'Last name' => 'نام خانوادگی',
        'Country / Region' => 'کشور',
        'Country/Region' => 'کشور',
        'Select a country/region' => 'کشور را انتخاب کنید',
        'Select a country / region…' => 'کشور را انتخاب کنید…',
        'Address' => 'نشانی',
        'Street address' => 'خیابان و پلاک',
        'House number and street name' => 'نام خیابان و شماره پلاک',
        'Address line 2' => 'ادامهٔ نشانی',
        'Add apartment, suite, etc.' => 'افزودن طبقه، واحد و جزئیات نشانی',
        'Add %s' => 'افزودن %s',
        '+ Add %s' => '+ افزودن %s',
        '+ Add %s, etc.' => '+ افزودن %s',
        'Select a %s' => '%s را انتخاب کنید',
        '+ Add apartment, suite, etc.' => '+ افزودن طبقه، واحد و جزئیات نشانی',
        'Apartment, suite, etc.' => 'طبقه، واحد و جزئیات نشانی',
        'Apartment, suite, unit, etc.' => 'طبقه، واحد و جزئیات نشانی',
        'Apartment, suite, unit, etc. (optional)' => 'طبقه و واحد (اختیاری)',
        'Town / City' => 'شهر',
        'City' => 'شهر',
        'State' => 'استان',
        'State / County' => 'استان',
        'Province' => 'استان',
        'Select a state…' => 'استان را انتخاب کنید…',
        'Select a state' => 'استان را انتخاب کنید',
        'ZIP Code' => 'کد پستی',
        'ZIP code' => 'کد پستی',
        'Postcode / ZIP' => 'کد پستی',
        'Postal code' => 'کد پستی',
        'Postcode' => 'کد پستی',
        'Company' => 'شرکت',
        'Company name' => 'نام شرکت',
        'Phone' => 'شماره تماس',
        'Phone (optional)' => 'شماره تماس (اختیاری)',
        'optional' => 'اختیاری',
        'Optional' => 'اختیاری',
        '%s (optional)' => '%s (اختیاری)',
        'Payment options' => 'روش پرداخت',
        'Payment methods' => 'روش‌های پرداخت',
        'There are no payment methods available. Please contact us for help placing your order.' => 'در حال حاضر روشی برای پرداخت در دسترس نیست. برای ثبت سفارش با فروشگاه تماس بگیرید.',
        'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.' => 'در حال حاضر روشی برای پرداخت در دسترس نیست. برای دریافت راهنمایی با فروشگاه تماس بگیرید.',
        'Use another payment method.' => 'روش پرداخت دیگری را انتخاب کنید.',
        'Other available payment methods' => 'سایر روش‌های پرداخت',
        'Save payment information to my account for future purchases.' => 'اطلاعات پرداخت برای خریدهای بعدی در حساب من ذخیره شود.',
        'Loading payment options… ' => 'در حال بارگذاری روش‌های پرداخت… ',
        'Loading payment options…' => 'در حال بارگذاری روش‌های پرداخت…',
        'Additional order information' => 'اطلاعات تکمیلی سفارش',
        'Additional information' => 'اطلاعات تکمیلی',
        'Add a note to your order' => 'یادداشت برای سفارش',
        'Notes about your order.' => 'یادداشت سفارش.',
        'Notes about your order, e.g. special notes for delivery.' => 'در صورت نیاز، توضیحی برای تحویل سفارش بنویسید.',
        'Order notes' => 'یادداشت سفارش',
        'Your order' => 'سفارش شما',
        'Order summary' => 'خلاصهٔ سفارش',
        'Place Order' => 'ثبت سفارش',
        'Place order' => 'ثبت سفارش',
        'Terms and Conditions' => 'قوانین و مقررات',
        'Privacy Policy' => 'حریم خصوصی',
        'terms and conditions' => 'قوانین و مقررات',
        'privacy policy' => 'حریم خصوصی',
        'By proceeding with your purchase you agree to our %1$s and %2$s' => 'با ادامهٔ خرید، %1$s و %2$s را می‌پذیرید.',
        'By proceeding with your purchase you agree to our %s' => 'با ادامهٔ خرید، %s را می‌پذیرید.',
        'Notifications' => 'اعلان‌ها',
        'Dismiss this notice' => 'بستن پیام',
        'Error:' => 'خطا:',
        'Loading…' => 'در حال بارگذاری…',
        'Loading price…' => 'در حال بارگذاری قیمت…',
        'Loading price… ' => 'در حال بارگذاری قیمت… ',
        'Loading products in cart…' => 'در حال بارگذاری کالاهای سبد…',
        'Loading shipping options…' => 'در حال بارگذاری روش‌های ارسال…',
        'Loading shipping rates…' => 'در حال محاسبه هزینهٔ ارسال…',
        'Please select a valid option' => 'یک گزینهٔ معتبر انتخاب کنید.',
        '%s is invalid' => '%s معتبر نیست.',
        'Please enter a valid %s' => '%s معتبر وارد کنید.',
        'Please enter a valid postcode' => 'کد پستی معتبر وارد کنید.',
        'Please enter a valid email address' => 'نشانی ایمیل معتبر وارد کنید.',
        'Please enter a valid password' => 'رمز عبور معتبر وارد کنید.',
        'Please enter a valid phone number' => 'شماره تماس معتبر وارد کنید.',
        'This field is required.' => 'تکمیل این فیلد الزامی است.',
        'Sorry, we do not allow orders from the selected country' => 'ثبت سفارش از کشور انتخاب‌شده امکان‌پذیر نیست.',
        'Sorry, we do not ship orders to the selected country' => 'امکان ارسال به کشور انتخاب‌شده وجود ندارد.',
        'Something went wrong. Please contact us to get assistance.' => 'مشکلی پیش آمد. برای دریافت راهنمایی با فروشگاه تماس بگیرید.',
        'There was a problem with your payment option.' => 'در روش پرداخت انتخاب‌شده مشکلی پیش آمد. روش دیگری را انتخاب کنید یا با فروشگاه تماس بگیرید.',
        'There was a problem with your shipping option.' => 'در روش ارسال انتخاب‌شده مشکلی پیش آمد. روش دیگری را انتخاب کنید یا با فروشگاه تماس بگیرید.',
        'There is a problem with your cart' => 'سبد خرید نیاز به بررسی دارد',
        'Please edit your cart and try again.' => 'سبد خرید را ویرایش کنید و دوباره تلاش کنید.',
        'You must be logged in to checkout.' => 'برای تسویه‌حساب وارد حساب کاربری خود شوید.',
    );
    return $labels;
}

function vt_purchase_gettext( $translated, $message ) {
    if ( ! vt_purchase_screen() ) { return $translated; }
    $labels = vt_purchase_labels();
    return $labels[ $message ] ?? $translated;
}
add_filter( 'gettext_woocommerce', 'vt_purchase_gettext', 20, 2 );
add_filter( 'gettext_with_context_woocommerce', 'vt_purchase_gettext', 20, 2 );

add_filter( 'document_title_parts', function( $parts ) {
    $screen = vt_purchase_screen();
    if ( $screen ) {
        $parts['title'] = 'cart' === $screen ? 'سبد خرید' : 'تسویه‌حساب';
    }
    return $parts;
} );

add_action( 'wp_enqueue_scripts', function() {
    if ( ! vt_purchase_screen() ) { return; }
    $messages = array_map( function( $label ) { return array( $label ); }, vt_purchase_labels() );
    $messages['%d item'] = array( '%d کالا', '%d کالا' );
    $messages['%d item in your cart'] = array( '%d کالا در سبد خرید', '%d کالا در سبد خرید' );
    $total_price = 'قیمت <quantity/> عدد از <productName/>: <price/>';
    $messages['Total price for <quantity/> <productName/> item: <price/>'] = array( $total_price, $total_price );
    wp_add_inline_script( 'wp-i18n', 'wp.i18n.setLocaleData(' . wp_json_encode( $messages ) . ', "woocommerce");', 'after' );
}, 99 );

function vt_purchase_country_labels( $countries ) {
    $store_api = defined( 'REST_REQUEST' ) && REST_REQUEST && isset( $_SERVER['REQUEST_URI'] ) && false !== strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), '/wc/store/' );
    if ( ( is_admin() && ! $store_api ) || ! class_exists( 'Locale' ) ) { return $countries; }
    foreach ( $countries as $code => $name ) {
        $label = Locale::getDisplayRegion( 'und_' . $code, 'fa' );
        if ( $label && $label !== $code ) {
            $countries[ $code ] = $label;
        }
    }
    return $countries;
}
add_filter( 'woocommerce_countries_allowed_countries', 'vt_purchase_country_labels' );
add_filter( 'woocommerce_countries_shipping_countries', 'vt_purchase_country_labels' );
add_filter( 'woocommerce_countries', 'vt_purchase_country_labels' );
