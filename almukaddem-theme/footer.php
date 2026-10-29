<?php
/**
 * The footer for our theme.
 *
 * @package almukaddem
 */
?>

    <!-- Footer -->
    <footer class="bg-primary-900 text-slate-300 border-t-2 border-accent-700 pt-12 pb-6 mt-12 font-serif relative overflow-hidden">
        <div class="absolute inset-0 opacity-5 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 relative z-10">

            <!-- About -->
            <div>
                <div class="flex items-center gap-3 mb-4 text-white">
                    <i class="fa-solid fa-book-quran text-2xl text-accent-200"></i>
                    <h2 class="text-lg font-bold font-sans"><?php bloginfo( 'name' ); ?></h2>
                </div>
                <p class="text-xs leading-relaxed text-slate-300">
                    <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
                </p>
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="mt-4"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-bold text-white mb-4 font-sans tracking-wider border-b border-white/5 pb-2"><?php esc_html_e( 'روابط سريعة', 'almukaddem' ); ?></h3>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'space-y-2.5 text-xs',
                        'container'      => false,
                    ) );
                } else { ?>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="<?php echo esc_url( home_url( '/biography' ) ); ?>" class="hover:text-accent-200 transition duration-300 flex items-center gap-2"><i class="fa-solid fa-angle-left text-[10px] text-accent-700"></i> <?php esc_html_e( 'من هو الشيخ؟', 'almukaddem' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="hover:text-accent-200 transition duration-300 flex items-center gap-2"><i class="fa-solid fa-angle-left text-[10px] text-accent-700"></i> <?php esc_html_e( 'السلاسل العلمية المكتملة', 'almukaddem' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fatwa' ) ); ?>" class="hover:text-accent-200 transition duration-300 flex items-center gap-2"><i class="fa-solid fa-angle-left text-[10px] text-accent-700"></i> <?php esc_html_e( 'الفتاوى الشرعية', 'almukaddem' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="hover:text-accent-200 transition duration-300 flex items-center gap-2"><i class="fa-solid fa-angle-left text-[10px] text-accent-700"></i> <?php esc_html_e( 'تواصل معنا', 'almukaddem' ); ?></a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- Contact & Social -->
            <div>
                <h3 class="text-sm font-bold text-white mb-4 font-sans tracking-wider border-b border-white/5 pb-2"><?php esc_html_e( 'تواصل معنا', 'almukaddem' ); ?></h3>
                <p class="text-xs mb-4 text-slate-300"><?php esc_html_e( 'تابع الحسابات الرسمية ليصلك كل جديد', 'almukaddem' ); ?></p>
                <div class="flex gap-2.5">
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-accent-700 hover:text-white transition-all"><i class="fa-brands fa-youtube text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-accent-700 hover:text-white transition-all"><i class="fa-brands fa-telegram text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-accent-700 hover:text-white transition-all"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-accent-700 hover:text-white transition-all"><i class="fa-brands fa-twitter text-sm"></i></a>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-white/5 pt-6 text-xs font-sans flex flex-col sm:flex-row justify-between items-center container mx-auto px-4 gap-4 relative z-10">
            <p class="text-slate-400"><?php printf( esc_html__( 'جميع الحقوق محفوظة © %s %s', 'almukaddem' ), get_bloginfo( 'name' ), gmdate( 'Y' ) ); ?></p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
