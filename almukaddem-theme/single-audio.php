<?php
/**
 * Single Audio template (محاضرة / درس صوتي مفرد).
 *
 * @package almukaddem
 */

get_header();

while ( have_posts() ) : the_post();
    $audio_url = almukaddem_get_audio_url();
    $duration  = almukaddem_get_field( 'audio_duration' );
    $series_terms = get_the_terms( get_the_ID(), 'audio_series' );
    $series_name  = ( $series_terms && ! is_wp_error( $series_terms ) ) ? $series_terms[0]->name : '';
    $series_link  = ( $series_terms && ! is_wp_error( $series_terms ) ) ? get_term_link( $series_terms[0] ) : '';
?>

    <main class="container mx-auto px-4 py-8 max-w-6xl" x-data="{ isPlaying: false }">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-500 font-medium mb-6 flex items-center gap-2 flex-wrap">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="hover:text-primary-700 transition-colors"><?php esc_html_e( 'المكتبة الصوتية', 'almukaddem' ); ?></a>
            <?php if ( $series_link ) : ?>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( $series_link ); ?>" class="hover:text-primary-700 transition-colors"><?php echo esc_html( $series_name ); ?></a>
            <?php endif; ?>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php the_title(); ?></span>
        </div>

        <!-- HERO AUDIO PLAYER -->
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 rounded-3xl p-6 md:p-10 mb-8 relative overflow-hidden shadow-xl border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10">
                <!-- Meta -->
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <?php if ( $series_link ) : ?>
                        <span class="bg-accent-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm"><i class="fa-solid fa-layer-group ml-1"></i> <?php esc_html_e( 'ضمن سلسلة', 'almukaddem' ); ?></span>
                        <a href="<?php echo esc_url( $series_link ); ?>" class="text-accent-200 hover:text-white transition-colors text-sm font-bold border-b border-accent-700/50 hover:border-white pb-0.5"><?php echo esc_html( $series_name ); ?></a>
                    <?php endif; ?>
                </div>

                <h2 class="text-2xl md:text-4xl font-bold text-white mb-4 leading-snug"><?php the_title(); ?></h2>

                <div class="flex flex-wrap items-center gap-6 text-sm text-primary-200 font-serif mb-8 border-b border-white/10 pb-6">
                    <?php if ( $duration ) : ?>
                        <span><i class="fa-regular fa-clock text-accent-500 ml-1"></i> <?php echo esc_html( sprintf( __( 'المدة: %s', 'almukaddem' ), $duration ) ); ?></span>
                    <?php endif; ?>
                    <span><i class="fa-regular fa-calendar text-accent-500 ml-1"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                    <span><i class="fa-solid fa-microphone-lines text-accent-500 ml-1"></i> <?php esc_html_e( 'جودة عالية (MP3)', 'almukaddem' ); ?></span>
                </div>

                <!-- Player Interface -->
                <?php if ( $audio_url ) : ?>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <audio x-ref="player" @play="isPlaying = true" @pause="isPlaying = false" @ended="isPlaying = false" class="hidden">
                        <source src="<?php echo esc_url( $audio_url ); ?>" type="audio/mpeg">
                    </audio>
                    <div class="flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
                        <div class="flex items-center gap-4 w-full md:w-auto order-3 md:order-1 justify-center md:justify-start">
                            <button @click="$refs.player.muted = !$refs.player.muted" class="text-slate-300 hover:text-white transition-colors" title="<?php esc_attr_e( 'كتم الصوت', 'almukaddem' ); ?>"><i class="fa-solid fa-volume-high"></i></button>
                        </div>
                        <div class="flex items-center gap-6 md:gap-8 w-full md:w-auto justify-center order-1 md:order-2">
                            <button class="text-white/70 hover:text-white transition-transform hover:scale-110" @click="$refs.player.currentTime -= 15"><i class="fa-solid fa-rotate-left text-lg"></i></button>
                            <button @click="isPlaying ? $refs.player.pause() : $refs.player.play()" class="w-16 h-16 rounded-full bg-accent-500 hover:bg-accent-400 text-primary-950 flex items-center justify-center text-2xl shadow-[0_0_20px_rgba(234,179,8,0.4)] transition-all transform hover:scale-105 border-4 border-white/10">
                                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play ml-1'"></i>
                            </button>
                            <button class="text-white/70 hover:text-white transition-transform hover:scale-110" @click="$refs.player.currentTime += 15"><i class="fa-solid fa-rotate-right text-lg"></i></button>
                        </div>
                        <div class="flex w-full md:w-auto justify-center md:justify-end order-2 md:order-3">
                            <a href="<?php echo esc_url( $audio_url ); ?>" download class="bg-accent-600 hover:bg-accent-500 text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-2 group border border-accent-500">
                                <i class="fa-solid fa-cloud-arrow-down group-hover:-translate-y-1 transition-transform"></i> <?php esc_html_e( 'تحميل MP3', 'almukaddem' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php else : ?>
                    <div class="bg-white/10 rounded-2xl p-6 border border-white/10 text-center text-primary-200 font-serif">
                        <i class="fa-solid fa-circle-exclamation text-accent-400 text-2xl mb-2 block"></i>
                        <?php esc_html_e( 'لم يتم إرفاق ملف صوتي لهذا الدرس بعد.', 'almukaddem' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- LAYOUT GRID -->
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- SIDEBAR: Series lessons -->
            <aside class="w-full lg:w-1/3 flex flex-col gap-6 order-2 lg:order-1">
                <?php if ( $series_terms && ! is_wp_error( $series_terms ) ) :
                    $sid = $series_terms[0]->term_id;
                    $lessons = new WP_Query( array(
                        'post_type'      => 'audio',
                        'posts_per_page' => 5,
                        'tax_query'      => array( array( 'taxonomy' => 'audio_series', 'field' => 'term_id', 'terms' => $sid ) ),
                        'orderby'        => 'date',
                        'order'          => 'ASC',
                    ) );
                    if ( $lessons->have_posts() ) : ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-primary-50 px-5 py-4 border-b border-primary-100 flex items-center justify-between">
                            <h3 class="font-bold text-primary-900 flex items-center gap-2"><i class="fa-solid fa-list-ul text-accent-600"></i> <?php esc_html_e( 'دروس السلسلة', 'almukaddem' ); ?></h3>
                            <span class="text-xs bg-white border border-primary-200 text-primary-700 px-2 py-1 rounded-md font-bold"><?php echo esc_html( $series_terms[0]->count ); ?> <?php esc_html_e( 'درس', 'almukaddem' ); ?></span>
                        </div>
                        <div class="p-3 flex flex-col gap-2 max-h-[500px] overflow-y-auto">
                            <?php while ( $lessons->have_posts() ) : $lessons->the_post();
                                $is_current = ( get_the_ID() === get_queried_object_id() ); ?>
                                <?php if ( $is_current ) : ?>
                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-primary-900 text-white shadow-md relative overflow-hidden border border-primary-800">
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent-500"></div>
                                        <div class="w-8 h-8 rounded-lg bg-white/20 text-accent-400 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-headphones-simple text-xs"></i></div>
                                        <div>
                                            <span class="text-[10px] text-primary-200 font-bold block mb-1"><?php esc_html_e( 'الدرس الحالي', 'almukaddem' ); ?></span>
                                            <h4 class="font-bold text-sm leading-snug"><?php the_title(); ?></h4>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="group flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 group-hover:text-primary-600 group-hover:bg-primary-50"><i class="fa-solid fa-play text-xs"></i></div>
                                        <h4 class="font-semibold text-slate-700 text-sm group-hover:text-primary-700 transition-colors"><?php the_title(); ?></h4>
                                    </a>
                                <?php endif; ?>
                            <?php endwhile; wp_reset_postdata(); ?>
                            <a href="<?php echo esc_url( $series_link ); ?>" class="text-center text-xs font-bold text-primary-700 hover:text-accent-700 py-3 mt-2 border-t border-slate-100"><?php esc_html_e( 'عرض كامل السلسلة', 'almukaddem' ); ?> <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i></a>
                        </div>
                    </div>
                    <?php endif;
                endif; ?>

                <!-- Transcript link -->
                <a href="<?php echo esc_url( get_post_type_archive_link( 'book' ) ); ?>" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between group hover:border-primary-300 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center text-xl group-hover:bg-primary-100"><i class="fa-solid fa-file-lines"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-800"><?php esc_html_e( 'التفريغ النصي', 'almukaddem' ); ?></h4>
                            <p class="text-xs text-slate-500 font-serif"><?php esc_html_e( 'اقرأ الدرس مفرغاً كنص', 'almukaddem' ); ?></p>
                        </div>
                    </div>
                    <i class="fa-solid fa-arrow-left text-slate-300 group-hover:text-primary-600 transition-transform group-hover:-translate-x-1"></i>
                </a>
            </aside>

            <!-- MAIN: Description -->
            <section class="w-full lg:w-2/3 flex flex-col gap-6 order-1 lg:order-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <h3 class="text-xl font-bold text-primary-900 mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-info-circle text-accent-500"></i> <?php esc_html_e( 'نبذة عن المحاضرة وعناصر الدرس', 'almukaddem' ); ?>
                    </h3>
                    <div class="article-content prose prose-slate prose-lg max-w-none font-serif text-slate-700 leading-loose">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-bold text-slate-400 ml-2"><?php esc_html_e( 'كلمات دلالية:', 'almukaddem' ); ?></span>
                        <?php
                        $tags = get_the_terms( get_the_ID(), 'audio_topic' );
                        if ( $tags && ! is_wp_error( $tags ) ) :
                            foreach ( $tags as $tg ) :
                                echo '<a href="' . esc_url( get_term_link( $tg ) ) . '" class="bg-slate-100 hover:bg-primary-50 text-slate-600 hover:text-primary-700 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">' . esc_html( $tg->name ) . '</a>';
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
            </section>
        </div>
    </main>

<?php
endwhile;
get_footer();
