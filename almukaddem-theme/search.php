<?php
/**
 * Search results template.
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 max-w-5xl">

        <!-- Page Hero -->
        <div class="bg-gradient-to-br from-primary-900 to-slate-900 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner mx-auto mb-4">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    <?php printf( esc_html__( 'نتائج البحث عن: %s', 'almukaddem' ), '<span class="text-accent-400">' . get_search_query() . '</span>' ); ?>
                </h2>
                <p class="text-sm text-primary-200 font-serif">
                    <?php
                    global $wp_query;
                    printf( esc_html( _n( '%s نتيجة', '%s نتيجة', $wp_query->found_posts, 'almukaddem' ) ), number_format_i18n( $wp_query->found_posts ) );
                    ?>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col group' ); ?>>
                        <div class="mb-3">
                            <span class="bg-primary-50 text-primary-700 text-[10px] font-bold px-3 py-1 rounded-full border border-primary-100">
                                <?php
                                $post_type_obj = get_post_type_object( get_post_type() );
                                echo esc_html( $post_type_obj ? $post_type_obj->labels->singular_name : get_post_type() );
                                ?>
                            </span>
                        </div>
                        <h3 class="font-bold text-lg text-primary-900 leading-snug mb-3 group-hover:text-accent-700 transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="text-slate-600 text-sm font-serif leading-loose line-clamp-3 mb-4 flex-grow"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="text-accent-700 hover:text-primary-800 text-xs font-bold transition-colors flex items-center gap-1">
                            <?php esc_html_e( 'عرض التفاصيل', 'almukaddem' ); ?> <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        </a>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-span-full bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                    <i class="fa-solid fa-face-frown text-5xl text-slate-200 mb-4"></i>
                    <h3 class="font-bold text-xl text-slate-700 mb-2"><?php esc_html_e( 'لا توجد نتائج مطابقة', 'almukaddem' ); ?></h3>
                    <p class="text-slate-500 text-sm font-serif mb-6"><?php esc_html_e( 'حاول تعديل كلمات البحث أو تصفح الأقسام الرئيسية.', 'almukaddem' ); ?></p>
                    <div class="max-w-sm mx-auto"><?php get_search_form(); ?></div>
                </div>
            <?php endif; ?>
        </div>

        <?php almukaddem_pagination(); ?>
    </main>

<?php
get_footer();
