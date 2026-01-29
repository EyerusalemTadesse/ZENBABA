<?php
// Ensure session exists
if (session_status() === PHP_SESSION_NONE) session_start();
/* Language */
$lang = $_SESSION['lang'] ?? 'en';

/* Translations */
$translations = [
    'en' => [
        'cart' => 'Cart',
        'logout' => 'Logout',
        'login' => 'Login',
        'register' => 'Register',
        'welcome_message' => 'Welcome to Zenbaba Market',
        'hero_subtitle' => 'Discover handmade Ethiopian crafts delivered to your doorstep',
        'shop_now' => 'Shop Now',
        'our_story' => 'Our Story',
        'about_text' => 'Zenbaba Market empowers handmade creators by transforming passion into a trusted online brand.',
        'search_placeholder' => 'Search for products...',
        'search_button' => 'Search',
        'categories' => 'Categories',
        'all' => 'All',
        'our_products' => 'Our Products',
        'showing_results' => 'Showing results for:',
        'add_to_cart' => 'Add to Cart',
        'no_products_found' => 'No products found.',
        'all_rights_reserved' => 'All rights reserved.',
    ],
    'am' => [
        'cart' => 'የግብይት ጋሪ',
        'logout' => 'ውጣ',
        'login' => 'ይግቡ',
        'register' => 'ይመዝገቡ',
        'welcome_message' => 'እንኳን ወደ ዘንባባ ገበያ በደህና መጡ',
        'hero_subtitle' => 'የኢትዮጵያ የእጅ ስራ ምርቶች ቤትዎ ድረስ መተዋል',
        'shop_now' => 'ግብይት ጀምር',
        'our_story' => 'ታሪካችን',
        'about_text' => 'ዘንባባ ገበያ የእጅ ስራ ባለሙያዎችን ደግፎ ብቁ የገበያ ታማኝነት ይገነባል።',
        'search_placeholder' => 'ምርቶችን ፈልግ...',
        'search_button' => 'ፈልግ',
        'categories' => 'ምድቦች',
        'all' => 'ሁሉም',
        'our_products' => 'ምርቶቻችን',
        'showing_results' => 'የተገኙ ውጤቶች:',
        'add_to_cart' => 'ወደ ግብይት ጋሪ ጨምር',
        'no_products_found' => 'ምርቶች አልተገኙም።',
        'all_rights_reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው።',
    ]
];

/* Translation helper */
function t($key) {
    global $translations, $lang;
    return $translations[$lang][$key] ?? $key;
}
?>

