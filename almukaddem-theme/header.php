<?php
/**
 * The header for our theme.
 *
 * @package almukaddem
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'font-sans text-slate-800' ); ?> x-data="{ mobileMenuOpen: false, searchOpen: false }">
<?php wp_body_open(); ?>

    <!-- Top Bar -->
    <div class="bg-primary-950 text-slate-200 py-2 text-xs sm:text-sm border-b border-accent-700/30">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-4 space-x-reverse">
                <span class="text-accent-200"><i class="fa-regular fa-calendar-alt ml-1"></i> <?php echo esc_html( almukaddem_today_date() ); ?></span>
            </div>
            <div class="flex items-center space-x-4 space-x-reverse">
                <a href="#" class="hover:text-accent-200 transition duration-300"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="hover:text-accent-200 transition duration-300"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="hover:text-accent-200 transition duration-300"><i class="fa-brands fa-telegram"></i></a>
                <a href="#" class="hover:text-accent-200 transition duration-300"><i class="fa-brands fa-youtube"></i></a>
                <span class="border-r border-primary-700 h-4 mx-2"></span>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'profile.php' ) ); ?>" class="hover:text-accent-200 transition duration-300 font-medium"><?php esc_html_e( 'حسابي', 'almukaddem' ); ?></a>
                <?php else : ?>
                    <a href="<?php echo esc_url( wp_login_url() ); ?>" class="hover:text-accent-200 transition duration-300 font-medium"><?php esc_html_e( 'تسجيل الدخول', 'almukaddem' ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-slate-100 transition-all duration-300">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">

                <!-- Logo & Branding -->
                <div class="flex items-center gap-4">
                    <button @click="mobileMenuOpen = true" class="lg:hidden text-slate-600 hover:text-primary-700 text-2xl focus:outline-none" aria-label="<?php esc_attr_e( 'القائمة', 'almukaddem' ); ?>">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group">
                        <?php if ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-primary-700 border border-primary-100 group-hover:border-accent-600 group-hover:text-accent-700 transition-all duration-300">
                                <i class="fa-solid fa-book-quran text-2xl"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold text-primary-900 leading-tight group-hover:text-primary-700 transition duration-300"><?php bloginfo( 'name' ); ?></h1>
                            <p class="text-xs text-accent-700 font-semibold hidden sm:block tracking-wider"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'hidden lg:flex items-center gap-8 font-semibold text-slate-600',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ) );
                } else {
                    almukaddem_default_menu();
                }
                ?>

                <!-- Search -->
                <div class="relative hidden md:block w-64">
                    <?php get_search_form(); ?>
                </div>

                <!-- Mobile Search Toggle -->
                <button @click="searchOpen = !searchOpen" class="md:hidden text-slate-600 text-xl hover:text-primary-700 transition" aria-label="<?php esc_attr_e( 'بحث', 'almukaddem' ); ?>">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>

            <!-- Mobile Search Bar (Toggleable) -->
            <div x-show="searchOpen" x-collapse class="md:hidden mt-4">
                <div class="relative">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/80 z-50 lg:hidden"
         @click="mobileMenuOpen = false" style="display:none;"></div>

    <!-- Mobile Menu Drawer -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 bottom-0 w-72 bg-white z-50 shadow-2xl flex flex-col lg:hidden"
         style="display:none;">

        <div class="p-4 flex justify-between items-center border-b border-slate-100 bg-primary-50">
            <span class="font-bold text-primary-900"><?php esc_html_e( 'القائمة الرئيسية', 'almukaddem' ); ?></span>
            <button @click="mobileMenuOpen = false" class="text-slate-500 hover:text-accent-700 text-xl">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <div class="p-4 flex-1 overflow-y-auto">
            <?php
            if ( has_nav_menu( 'mobile' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'mobile',
                    'menu_class'     => 'flex flex-col space-y-2 font-medium',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) );
            } else {
                echo '<nav class="flex flex-col space-y-2 font-medium">';
                echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="py-3 px-4 hover:bg-slate-50 rounded-xl"><i class="fa-solid fa-home w-6 text-center text-accent-700"></i> الرئيسية</a>';
                echo '<a href="' . esc_url( get_post_type_archive_link( 'audio' ) ) . '" class="py-3 px-4 hover:bg-slate-50 rounded-xl"><i class="fa-solid fa-microphone w-6 text-center text-accent-700"></i> الصوتيات والمرئيات</a>';
                echo '<a href="' . esc_url( get_post_type_archive_link( 'book' ) ) . '" class="py-3 px-4 hover:bg-slate-50 rounded-xl"><i class="fa-solid fa-file-lines w-6 text-center text-accent-700"></i> التفريغات</a>';
                echo '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" class="py-3 px-4 hover:bg-slate-50 rounded-xl"><i class="fa-solid fa-book w-6 text-center text-accent-700"></i> المقالات والكتب</a>';
                echo '<a href="' . esc_url( get_post_type_archive_link( 'fatwa' ) ) . '" class="py-3 px-4 hover:bg-slate-50 rounded-xl"><i class="fa-solid fa-scale-balanced w-6 text-center text-accent-700"></i> الفتاوى</a>';
                echo '</nav>';
            }
            ?>
        </div>
    </div>

    <!-- Ticker / Alerts -->
    <div class="bg-white border-y border-slate-100 py-2.5">
        <div class="container mx-auto px-4 flex items-center">
            <span class="bg-accent-700 text-white text-xs font-bold px-3 py-1 rounded-lg whitespace-nowrap ml-3 shadow-sm"><?php esc_html_e( 'جديد الموقع', 'almukaddem' ); ?></span>
            <div class="overflow-hidden w-full relative h-6">
                <div class="absolute whitespace-nowrap animate-[marquee_25s_linear_infinite] text-sm text-primary-900 font-medium">
                    <?php
                    $ticker_posts = new WP_Query( array(
                        'post_type'      => array( 'post', 'audio', 'video' ),
                        'posts_per_page' => 6,
                    ) );
                    $items = array();
                    while ( $ticker_posts->have_posts() ) : $ticker_posts->the_post();
                        $items[] = get_the_title();
                    endwhile;
                    wp_reset_postdata();
                    echo esc_html( ! empty( $items ) ? implode( ' • ', $items ) : 'تابعونا على القناة الرسمية على التليجرام' );
                    ?>
                </div>
            </div>
        </div>
    </div>
