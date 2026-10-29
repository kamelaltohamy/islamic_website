<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-16 max-w-3xl text-center">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 md:p-16 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-l from-primary-900 to-accent-600"></div>
            <div class="text-9xl font-black text-primary-100 mb-4">٤٠٤</div>
            <h1 class="text-2xl md:text-3xl font-bold text-primary-900 mb-3"><?php esc_html_e( 'الصفحة غير موجودة', 'almukaddem' ); ?></h1>
            <p class="text-slate-500 font-serif leading-relaxed mb-8 max-w-lg mx-auto"><?php esc_html_e( 'عذراً، الصفحة التي تبحث عنها غير متوفرة أو ربما تم نقلها. يمكنك استخدام البحث أو العودة للصفحة الرئيسية.', 'almukaddem' ); ?></p>

            <div class="max-w-md mx-auto mb-8"><?php get_search_form(); ?></div>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 bg-primary-900 hover:bg-primary-800 text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm">
                <i class="fa-solid fa-home"></i> <?php esc_html_e( 'العودة للرئيسية', 'almukaddem' ); ?>
            </a>
        </div>
    </main>

<?php
get_footer();
