<?php
/**
 * The main template file (fallback for posts blog).
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-8">

        <section class="w-full lg:w-3/4 flex flex-col gap-6">
            <div class="flex items-center gap-3 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center text-lg border border-primary-100/30">
                    <i class="fa-solid fa-newspaper text-accent-700"></i>
                </div>
                <h2 class="text-lg font-bold text-primary-900">
                    <?php
                    if ( is_home() && ! is_front_page() ) {
                        single_post_title();
                    } else {
                        esc_html_e( 'المقالات والبحوث', 'almukaddem' );
                    }
                    ?>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article <?php post_class( 'bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group article-card-hover flex flex-col' ); ?>>
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="mb-4 flex justify-between items-center">
                                    <?php
                                    $cats = get_the_category();
                                    if ( ! empty( $cats ) ) :
                                        echo '<span class="bg-primary-50 text-primary-700 text-[10px] font-bold px-3 py-1 rounded-full border border-primary-100">' . esc_html( $cats[0]->name ) . '</span>';
                                    endif;
                                    ?>
                                    <span class="text-[11px] text-slate-400 font-serif flex items-center gap-1"><i class="fa-regular fa-clock text-accent-500"></i> <?php echo esc_html( almukaddem_reading_time() ); ?></span>
                                </div>
                                <h3 class="font-bold text-lg text-primary-900 leading-snug mb-3 group-hover:text-accent-700 transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="text-slate-600 text-sm font-serif leading-loose line-clamp-3 mb-6 flex-grow"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                        <i class="fa-regular fa-calendar text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="text-accent-700 hover:text-primary-800 text-xs font-bold transition-colors flex items-center gap-1">
                                        <?php esc_html_e( 'اقرأ المزيد', 'almukaddem' ); ?> <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا توجد مقالات حالياً.', 'almukaddem' ); ?></p>
                <?php endif; ?>
            </div>

            <?php almukaddem_pagination(); ?>
        </section>

        <?php get_sidebar(); ?>

    </main>

<?php
get_footer();
