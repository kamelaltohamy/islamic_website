<?php
/**
 * Archive template for the Audio library (المكتبة الصوتية).
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 max-w-6xl" x-data="{ activeTab: 'series' }">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php esc_html_e( 'المكتبة الصوتية', 'almukaddem' ); ?></span>
        </div>

        <!-- Page Hero -->
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-700">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner">
                    <i class="fa-solid fa-headphones-simple"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2"><?php esc_html_e( 'المكتبة الصوتية', 'almukaddem' ); ?></h2>
                    <p class="text-sm text-primary-200 font-serif leading-relaxed max-w-xl"><?php esc_html_e( 'استمع إلى مئات المحاضرات، السلاسل العلمية، والدروس المنهجية الميسرة في مختلف فروع العلوم الشرعية.', 'almukaddem' ); ?></p>
                </div>
            </div>
        </div>

        <!-- Tabs (Series vs Singles) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-8">
            <div class="flex gap-8 border-b border-slate-100 mb-6">
                <button @click="activeTab = 'series'" class="pb-4 text-sm md:text-base font-bold transition-all relative flex items-center gap-2" :class="activeTab === 'series' ? 'text-primary-900' : 'text-slate-400 hover:text-slate-600'">
                    <i class="fa-solid fa-layer-group text-lg" :class="activeTab === 'series' ? 'text-accent-600' : ''"></i> <?php esc_html_e( 'السلاسل العلمية', 'almukaddem' ); ?>
                    <div x-show="activeTab === 'series'" class="absolute bottom-0 right-0 w-full h-1 bg-accent-600 rounded-t-full"></div>
                </button>
                <button @click="activeTab = 'singles'" class="pb-4 text-sm md:text-base font-bold transition-all relative flex items-center gap-2" :class="activeTab === 'singles' ? 'text-primary-900' : 'text-slate-400 hover:text-slate-600'">
                    <i class="fa-solid fa-microphone-lines text-lg" :class="activeTab === 'singles' ? 'text-accent-600' : ''"></i> <?php esc_html_e( 'الصوتيات المنفردة', 'almukaddem' ); ?>
                    <div x-show="activeTab === 'singles'" class="absolute bottom-0 right-0 w-full h-1 bg-accent-600 rounded-t-full"></div>
                </button>
            </div>

            <!-- Tags Filter -->
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-xs text-slate-400 font-bold ml-2"><i class="fa-solid fa-filter"></i> <?php esc_html_e( 'تصنيف حسب:', 'almukaddem' ); ?></span>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="px-4 py-1.5 rounded-full text-xs font-bold border bg-primary-50 text-primary-800 border-primary-200 shadow-sm"><?php esc_html_e( 'الكل', 'almukaddem' ); ?></a>
                <?php
                $topics = get_terms( array( 'taxonomy' => 'audio_topic', 'hide_empty' => true ) );
                foreach ( $topics as $t ) :
                    echo '<a href="' . esc_url( get_term_link( $t ) ) . '" class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-slate-500 border-slate-200 hover:border-primary-300 hover:bg-slate-50 transition-colors">' . esc_html( $t->name ) . '</a>';
                endforeach;
                ?>
            </div>
        </div>

        <!-- TAB: Audio Series -->
        <div x-show="activeTab === 'series'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php
            $series = get_terms( array( 'taxonomy' => 'audio_series', 'hide_empty' => true ) );
            if ( ! empty( $series ) && ! is_wp_error( $series ) ) :
                foreach ( $series as $s ) :
                    $term_link = get_term_link( $s );
                    $series_sample = get_posts( array(
                        'post_type'      => 'audio',
                        'posts_per_page' => 1,
                        'tax_query'      => array( array(
                            'taxonomy' => 'audio_series',
                            'field'    => 'term_id',
                            'terms'    => $s->term_id,
                        ) ),
                    ) );
                    $topic_terms = empty( $series_sample ) ? array() : wp_get_post_terms( $series_sample[0]->ID, 'audio_topic' );
                    $topic_terms = is_wp_error( $topic_terms ) ? array() : $topic_terms;
            ?>
                <a href="<?php echo esc_url( $term_link ); ?>" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:border-primary-200 transition-all group">
                    <div class="h-36 bg-gradient-to-br from-primary-800 to-primary-950 relative p-5 flex flex-col justify-between overflow-hidden">
                        <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <?php
                            if ( ! empty( $topic_terms ) ) :
                                echo '<span class="bg-white/10 backdrop-blur-md text-accent-400 text-[10px] font-bold px-2.5 py-1 rounded-md border border-white/10"><i class="fa-solid fa-tag ml-1"></i> ' . esc_html( $topic_terms[0]->name ) . '</span>';
                            endif;
                            ?>
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white border border-white/5 group-hover:scale-110 transition-transform"><i class="fa-solid fa-folder-open text-lg"></i></div>
                        </div>
                        <h3 class="relative z-10 font-bold text-white text-base leading-tight mt-2"><?php echo esc_html( $s->name ); ?></h3>
                    </div>
                    <div class="p-4 flex justify-between items-center bg-white">
                        <span class="text-xs text-slate-500 font-serif"><i class="fa-solid fa-list-ol text-accent-600 ml-1"></i> <?php echo esc_html( $s->count ); ?> <?php esc_html_e( 'درس صوتي', 'almukaddem' ); ?></span>
                        <span class="text-xs font-bold text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg border border-primary-100"><?php esc_html_e( 'تصفح', 'almukaddem' ); ?> <i class="fa-solid fa-chevron-left mr-1 text-[10px]"></i></span>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا توجد سلاسل علمية بعد.', 'almukaddem' ); ?></p>
            <?php endif; ?>
        </div>

        <!-- TAB: Single Audios -->
        <div x-show="activeTab === 'singles'" style="display:none;" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php
            $singles = new WP_Query( array(
                'post_type'      => 'audio',
                'posts_per_page' => 12,
            ) );
            if ( $singles->have_posts() ) :
                while ( $singles->have_posts() ) : $singles->the_post();
                    $duration = almukaddem_get_field( 'audio_duration' );
                    $topics   = get_the_terms( get_the_ID(), 'audio_topic' );
                ?>
                <a href="<?php the_permalink(); ?>" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md hover:border-primary-200 transition-all group">
                    <div class="w-14 h-14 flex-shrink-0 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center group-hover:bg-accent-600 group-hover:text-white group-hover:border-accent-600 transition-colors border border-primary-100">
                        <i class="fa-solid fa-play text-lg ml-1"></i>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <h3 class="font-bold text-sm text-primary-900 mb-1.5 truncate group-hover:text-primary-700 transition-colors"><?php the_title(); ?></h3>
                        <div class="flex items-center gap-3 text-[11px] text-slate-400 font-serif">
                            <?php if ( $topics && ! is_wp_error( $topics ) ) : ?>
                                <span class="bg-slate-50 px-2 py-0.5 rounded text-slate-500 font-sans font-bold"><i class="fa-solid fa-tag text-accent-600 ml-1"></i> <?php echo esc_html( $topics[0]->name ); ?></span>
                            <?php endif; ?>
                            <?php if ( $duration ) : ?>
                                <span><i class="fa-regular fa-clock text-accent-600 ml-1"></i> <?php echo esc_html( $duration ); ?></span>
                            <?php endif; ?>
                            <span class="hidden sm:inline"><i class="fa-regular fa-calendar text-accent-600 ml-1"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                        </div>
                    </div>
                </a>
                <?php endwhile; wp_reset_postdata();
            else : ?>
                <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا توجد مقاطع صوتية بعد.', 'almukaddem' ); ?></p>
            <?php endif; ?>
        </div>

    </main>

<?php
get_footer();
