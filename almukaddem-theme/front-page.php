<?php
/**
 * The front page template (homepage).
 *
 * @package almukaddem
 */

get_header();
?>

    <!-- Main Layout (Grid) -->
    <main class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-8">

        <!-- Sidebar (Right) -->
        <?php get_sidebar(); ?>

        <!-- Main Content Area (Left) -->
        <section class="w-full lg:w-3/4 flex flex-col gap-6">

            <!-- Section Header & Controls -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center text-lg border border-primary-100/30">
                        <i class="fa-solid fa-file-text text-accent-700"></i>
                    </div>
                    <h2 class="text-lg font-bold text-primary-900"><?php esc_html_e( 'أحدث المحتوى', 'almukaddem' ); ?></h2>
                </div>
            </div>

            <!-- Cards Grid (mixed latest content) -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php
                $latest = new WP_Query( array(
                    'post_type'      => array( 'post', 'audio', 'video', 'book' ),
                    'posts_per_page' => 9,
                ) );

                if ( $latest->have_posts() ) :
                    while ( $latest->have_posts() ) : $latest->the_post();
                        $pt   = get_post_type();
                        $icon = 'fa-file-text';
                        $type_label = 'مقال';
                        if ( 'audio' === $pt ) {
                            $icon = 'fa-microphone-lines';
                            $type_label = 'صوتي';
                        } elseif ( 'video' === $pt ) {
                            $icon = 'fa-play';
                            $type_label = 'مرئي';
                        } elseif ( 'book' === $pt ) {
                            $icon = 'fa-book-open';
                            $type_label = 'تفريغ';
                        }
                ?>
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden group flex flex-col h-full transform hover:-translate-y-1">
                        <a href="<?php the_permalink(); ?>" class="block">
                            <div class="relative h-40 bg-gradient-to-br from-primary-900 to-slate-900 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 opacity-5 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'almukaddem-card', array( 'class' => 'absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-70 transition' ) ); ?>
                                <?php endif; ?>
                                <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-sm flex items-center justify-center text-accent-200 z-10 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid <?php echo esc_attr( $icon ); ?> text-xl"></i>
                                </div>
                                <span class="absolute top-3 right-3 bg-accent-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-md z-10 shadow-sm"><?php echo esc_html( $type_label ); ?></span>
                            </div>
                        </a>
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex items-center gap-2 text-[10px] text-slate-400 mb-2">
                                <?php
                                $tax = ( 'audio' === $pt ) ? 'audio_series' : ( 'video' === $pt ? 'video_series' : 'category' );
                                $terms = get_the_terms( get_the_ID(), $tax );
                                if ( $terms && ! is_wp_error( $terms ) ) :
                                    echo '<span><i class="fa-regular fa-folder ml-1 text-accent-700"></i> ' . esc_html( $terms[0]->name ) . '</span>';
                                endif;
                                ?>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm leading-snug mb-3 group-hover:text-primary-700 transition">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="text-slate-600 text-xs font-serif line-clamp-2 flex-grow leading-relaxed"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                            <div class="mt-4 pt-4 border-t border-slate-50 flex justify-between items-center text-[10px] text-slate-400">
                                <span><i class="fa-regular fa-calendar ml-1 text-accent-700"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                <span><i class="fa-regular fa-eye ml-1 text-accent-700"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?></span>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="text-slate-500 col-span-full">' . esc_html__( 'لا يوجد محتوى حالياً.', 'almukaddem' ) . '</p>';
                endif;
                ?>
            </div>

            <!-- Pagination -->
            <?php almukaddem_pagination(); ?>

        </section>
    </main>

<?php
get_footer();
