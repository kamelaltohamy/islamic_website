<?php
/**
 * almukaddem functions and definitions
 *
 * @package almukaddem
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ALMUKADDEM_VERSION', '1.0.0' );

/**
 * Theme setup: add core supports and register nav menus.
 */
function almukaddem_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-logo', array(
        'height'      => 48,
        'width'       => 48,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'responsive-embeds' );

    add_theme_support( 'menus' );

    register_nav_menus( array(
        'primary' => __( 'القائمة الرئيسية (Header)', 'almukaddem' ),
        'mobile'  => __( 'قائمة الجوال', 'almukaddem' ),
        'footer'  => __( 'روابط الفوتر', 'almukaddem' ),
    ) );

    // Image sizes
    add_image_size( 'almukaddem-card', 600, 400, true );
    add_image_size( 'almukaddem-thumb', 120, 120, true );
}
add_action( 'after_setup_theme', 'almukaddem_setup' );

/**
 * Enqueue scripts and styles.
 */
function almukaddem_enqueue_scripts() {
    // Google Fonts: Alexandria & Amiri
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap',
        array(),
        null
    );

    // FontAwesome
    wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

    // Main theme stylesheet
    wp_enqueue_style( 'almukaddem-style', get_stylesheet_uri(), array(), ALMUKADDEM_VERSION );

    // Tailwind CSS via CDN (Production: build locally and replace this)
    wp_enqueue_script( 'tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false );

    // Tailwind config (Royal Blue & Islamic Gold theme)
    $tailwind_config = "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Alexandria', 'sans-serif'],
                        serif: ['Amiri', 'serif']
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554'
                        },
                        accent: {
                            50: '#fefce8', 100: '#fef08a', 200: '#fde047', 500: '#eab308',
                            600: '#ca8a04', 700: '#b45309', 800: '#92400e'
                        },
                        surface: '#f8fafc'
                    }
                }
            }
        }
    ";
    wp_add_inline_script( 'tailwind-css', $tailwind_config, 'before' );

    // Alpine.js Collapse plugin (used in fatwa accordion & mobile menus)
    wp_enqueue_script( 'alpine-collapse', 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js', array(), '3.x.x', true );

    // Alpine.js core
    wp_enqueue_script( 'alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.x.x', true );

    // Threaded comments reply
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'almukaddem_enqueue_scripts' );

/**
 * Preload fonts for performance.
 */
function almukaddem_resource_hints( $hints, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'almukaddem_resource_hints', 10, 2 );

/**
 * Register Custom Post Types.
 */
function almukaddem_register_post_types() {

    // ===== Audio (الصوتيات) =====
    register_post_type( 'audio', array(
        'labels' => array(
            'name'               => 'الصوتيات',
            'singular_name'      => 'مقطع صوتي',
            'menu_name'          => 'المكتبة الصوتية',
            'add_new'            => 'إضافة مقطع',
            'add_new_item'       => 'إضافة مقطع صوتي جديد',
            'edit_item'          => 'تعديل المقطع الصوتي',
            'new_item'           => 'مقطع صوتي جديد',
            'view_item'          => 'عرض المقطع',
            'search_items'       => 'بحث في الصوتيات',
            'not_found'          => 'لا توجد مقاطع صوتية',
            'not_found_in_trash' => 'لا توجد مقاطع في السلة',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-format-audio',
        'menu_position'=> 5,
        'rewrite'      => array( 'slug' => 'audio', 'with_front' => false ),
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest' => true,
    ) );

    // ===== Video (المرئيات) =====
    register_post_type( 'video', array(
        'labels' => array(
            'name'               => 'المرئيات',
            'singular_name'      => 'مقطع مرئي',
            'menu_name'          => 'المكتبة المرئية',
            'add_new'            => 'إضافة مقطع',
            'add_new_item'       => 'إضافة مقطع مرئي جديد',
            'edit_item'          => 'تعديل المقطع المرئي',
            'new_item'           => 'مقطع مرئي جديد',
            'view_item'          => 'عرض المقطع',
            'search_items'       => 'بحث في المرئيات',
            'not_found'          => 'لا توجد مقاطع مرئية',
            'not_found_in_trash' => 'لا توجد مقاطع في السلة',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-format-video',
        'menu_position'=> 6,
        'rewrite'      => array( 'slug' => 'video', 'with_front' => false ),
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest' => true,
    ) );

    // ===== Fatwa (الفتاوى) =====
    register_post_type( 'fatwa', array(
        'labels' => array(
            'name'               => 'الفتاوى',
            'singular_name'      => 'فتوى',
            'menu_name'          => 'الفتاوى الشرعية',
            'add_new'            => 'إضافة فتوى',
            'add_new_item'       => 'إضافة فتوى جديدة',
            'edit_item'          => 'تعديل الفتوى',
            'new_item'           => 'فتوى جديدة',
            'view_item'          => 'عرض الفتوى',
            'search_items'       => 'بحث في الفتاوى',
            'not_found'          => 'لا توجد فتاوى',
            'not_found_in_trash' => 'لا توجد فتاوى في السلة',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-balloon',
        'menu_position'=> 7,
        'rewrite'      => array( 'slug' => 'fatwa', 'with_front' => false ),
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest' => true,
    ) );

    // ===== Book / Transcript (التفريغات والكتب) =====
    register_post_type( 'book', array(
        'labels' => array(
            'name'               => 'التفريغات والكتب',
            'singular_name'      => 'تفريغ / كتاب',
            'menu_name'          => 'التفريغات والكتب',
            'add_new'            => 'إضافة تفريغ',
            'add_new_item'       => 'إضافة تفريغ/كتاب جديد',
            'edit_item'          => 'تعديل التفريغ',
            'new_item'           => 'تفريغ جديد',
            'view_item'          => 'عرض التفريغ',
            'search_items'       => 'بحث في التفريغات',
            'not_found'          => 'لا توجد تفريغات',
            'not_found_in_trash' => 'لا توجد تفريغات في السلة',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-book',
        'menu_position'=> 8,
        'rewrite'      => array( 'slug' => 'book', 'with_front' => false ),
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'almukaddem_register_post_types' );

/**
 * Register Custom Taxonomies.
 */
function almukaddem_register_taxonomies() {

    // Audio series (السلاسل الصوتية) - hierarchical like categories
    register_taxonomy( 'audio_series', 'audio', array(
        'labels' => array(
            'name'          => 'السلاسل العلمية الصوتية',
            'singular_name' => 'سلسلة صوتية',
            'add_new_item'  => 'إضافة سلسلة جديدة',
            'edit_item'     => 'تعديل السلسلة',
            'search_items'  => 'بحث في السلاسل',
            'all_items'     => 'كل السلاسل',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'audio-series', 'with_front' => false ),
    ) );

    // Audio topic (عقيدة، فقه، تفسير، حديث)
    register_taxonomy( 'audio_topic', 'audio', array(
        'labels' => array(
            'name'          => 'تصنيفات الصوتيات',
            'singular_name' => 'تصنيف صوتي',
            'add_new_item'  => 'إضافة تصنيف',
            'all_items'     => 'كل التصنيفات',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'audio-topic' ),
    ) );

    // Video category
    register_taxonomy( 'video_category', 'video', array(
        'labels' => array(
            'name'          => 'تصنيفات المرئيات',
            'singular_name' => 'تصنيف مرئي',
            'add_new_item'  => 'إضافة تصنيف',
            'all_items'     => 'كل التصنيفات',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'video-category' ),
    ) );

    register_taxonomy( 'video_series', 'video', array(
        'labels' => array(
            'name'          => 'السلاسل المرئية',
            'singular_name' => 'سلسلة مرئية',
            'all_items'     => 'كل السلاسل',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'video-series' ),
    ) );

    // Fatwa categories
    register_taxonomy( 'fatwa_category', 'fatwa', array(
        'labels' => array(
            'name'          => 'أبواب الفتاوى',
            'singular_name' => 'باب الفتاوى',
            'add_new_item'  => 'إضافة باب',
            'all_items'     => 'كل الأبواب',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'fatwa-category' ),
    ) );

    // Book categories
    register_taxonomy( 'book_category', 'book', array(
        'labels' => array(
            'name'          => 'تصنيفات التفريغات',
            'singular_name' => 'تصنيف تفريغ',
            'add_new_item'  => 'إضافة تصنيف',
            'all_items'     => 'كل التصنيفات',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'book-category' ),
    ) );

    // Article categories (extend default 'category' usage on posts)
}
add_action( 'init', 'almukaddem_register_taxonomies' );

/**
 * Helper: get a field value supporting ACF and post meta fallback.
 *
 * @param string $key     The field key.
 * @param int    $post_id Post ID.
 * @return mixed
 */
function almukaddem_get_field( $key, $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $key, $post_id );
        if ( $value ) {
            return $value;
        }
    }
    return get_post_meta( $post_id, $key, true );
}

/**
 * Helper: get audio file URL (supports ACF File array or direct URL).
 *
 * @param int $post_id Post ID.
 * @return string|false
 */
function almukaddem_get_audio_url( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $audio = almukaddem_get_field( 'audio_file', $post_id );
    if ( is_array( $audio ) && isset( $audio['url'] ) ) {
        return $audio['url'];
    }
    if ( is_string( $audio ) && $audio ) {
        return $audio;
    }
    // Try embedded audio in content
    return false;
}

/**
 * Helper: format Arabic-style date.
 */
function almukaddem_arabic_date( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $months = array(
        'January'   => 'يناير', 'February' => 'فبراير', 'March'     => 'مارس',
        'April'     => 'أبريل', 'May'      => 'مايو',   'June'      => 'يونيو',
        'July'      => 'يوليو', 'August'   => 'أغسطس', 'September' => 'سبتمبر',
        'October'   => 'أكتوبر', 'November' => 'نوفمبر', 'December'  => 'ديسمبر',
    );
    $date = get_the_date( 'j F Y', $post_id );
    return str_replace( array_keys( $months ), array_values( $months ), $date );
}

/**
 * Helper: approximate Hijri date using Intl extension if available.
 */
function almukaddem_hijri_date() {
    if ( class_exists( 'IntlCalendar' ) && class_exists( 'IntlDateFormatter' ) ) {
        try {
            $fmt = new IntlDateFormatter(
                'ar_SA@calendar=islamic',
                IntlDateFormatter::FULL,
                IntlDateFormatter::NONE,
                'Asia/Riyadh',
                IntlDateFormatter::TRADITIONAL
            );
            return $fmt->format( time() );
        } catch ( Exception $e ) {
            // fall through
        }
    }
    return date_i18n( 'j F Y' );
}

/**
 * Top bar Hijri date display.
 */
function almukaddem_today_date() {
    $days = array(
        'Sunday' => 'الأحد', 'Monday' => 'الإثنين', 'Tuesday' => 'الثلاثاء',
        'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة', 'Saturday' => 'السبت',
    );
    $day   = str_replace( array_keys( $days ), array_values( $days ), date( 'l' ) );
    $hijri = almukaddem_hijri_date();
    return sprintf( '%s، %s', $day, $hijri );
}

/**
 * Helper: reading time estimate for articles.
 */
function almukaddem_reading_time( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    $minutes = max( 1, ceil( $words / 200 ) );
    return sprintf( '%d دقيقة قراءة', $minutes );
}

/**
 * Default menu fallback - render a static primary nav.
 */
function almukaddem_default_menu() {
    echo '<nav class="hidden lg:flex items-center gap-8 font-semibold text-slate-600">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="hover:text-primary-700 transition duration-300">الرئيسية</a>';
    echo '<a href="' . esc_url( get_post_type_archive_link( 'audio' ) ) . '" class="hover:text-primary-700 transition duration-300">الصوتيات والمرئيات</a>';
    echo '<a href="' . esc_url( get_post_type_archive_link( 'book' ) ) . '" class="hover:text-primary-700 transition duration-300">التفريغات</a>';
    echo '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" class="hover:text-primary-700 transition duration-300">المقالات والكتب</a>';
    echo '<a href="' . esc_url( get_post_type_archive_link( 'fatwa' ) ) . '" class="hover:text-primary-700 transition duration-300">الفتاوى</a>';
    echo '</nav>';
}

/**
 * Pagination rendering.
 */
function almukaddem_pagination() {
    echo '<div class="flex justify-center mt-8">';
    echo '<nav class="flex items-center gap-1.5 bg-white rounded-xl shadow-sm border border-slate-100 p-1.5">';
    echo paginate_links( array(
        'prev_text' => '<i class="fa-solid fa-chevron-right text-xs"></i>',
        'next_text' => '<i class="fa-solid fa-chevron-left text-xs"></i>',
        'before_page_number' => '',
        'after_page_number'  => '',
    ) );
    echo '</nav>';
    echo '</div>';
}

/**
 * Add excerpt length & read more.
 */
function almukaddem_excerpt_length() {
    return 28;
}
add_filter( 'excerpt_length', 'almukaddem_excerpt_length' );

function almukaddem_excerpt_more() {
    return '…';
}
add_filter( 'excerpt_more', 'almukaddem_excerpt_more' );

/**
 * Add a CSS class to the body when a sticky player is shown (optional).
 */
function almukaddem_body_classes( $classes ) {
    $classes[] = 'font-sans';
    $classes[] = 'text-slate-800';
    return $classes;
}
add_filter( 'body_class', 'almukaddem_body_classes' );

/**
 * Widget areas (optional sidebars).
 */
function almukaddem_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'الشريط الجانبي العام', 'almukaddem' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'يظهر في الصفحات الداخلية والرئيسية', 'almukaddem' ),
        'before_widget' => '<div id="%1$s" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mb-6 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="font-bold text-primary-900 mb-4 text-sm flex items-center gap-2">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'منطقة الفوتر', 'almukaddem' ),
        'id'            => 'footer-1',
        'description'   => __( 'عناصر إضافية في الفوتر', 'almukaddem' ),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="font-bold text-white mb-4 font-sans tracking-wider border-b border-white/5 pb-2 text-sm">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'almukaddem_widgets_init' );

/**
 * Show post view count (simple meta counter).
 */
function almukaddem_get_views( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $count = get_post_meta( $post_id, 'almukaddem_views', true );
    if ( ! $count ) {
        $count = 0;
    }
    return $count;
}

function almukaddem_track_views( $post_id ) {
    if ( ! is_single() ) {
        return;
    }
    $count = get_post_meta( $post_id, 'almukaddem_views', true );
    $count = $count ? intval( $count ) + 1 : 1;
    update_post_meta( $post_id, 'almukaddem_views', $count );
}
add_action( 'wp_head', 'almukaddem_track_views' );

/**
 * Fallback hero pattern data URI constant used across templates.
 */
if ( ! defined( 'ALMUKADDEM_PATTERN' ) ) {
    define( 'ALMUKADDEM_PATTERN', "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+Cgk8cGF0aCBkPSJNMjAgMEwyMCA0ME0wIDIwTDQwIDIwIiBzdHJva2U9IiNmNTllMGIiIHN0cm9rZS13aWR0aD0iMSIvPgo8L3N2Zz4=" );
}
