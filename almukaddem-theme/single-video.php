<?php
/**
 * Single Video template (مقطع مرئي مفرد).
 *
 * @package almukaddem
 */

get_header();

while ( have_posts() ) : the_post();
    $video_url  = almukaddem_get_field( 'video_url' );
    $duration   = almukaddem_get_field( 'video_duration' );
    $audio_dl   = almukaddem_get_audio_url();
    $series     = get_the_terms( get_the_ID(), 'video_series' );
    $cats       = get_the_terms( get_the_ID(), 'video_category' );
    $series_name = ( $series && ! is_wp_error( $series ) ) ? $series[0]->name : '';
    $series_link = ( $series && ! is_wp_error( $series ) ) ? get_term_link( $series[0] ) : '';
?>

    <!-- CINEMATIC VIDEO SECTION -->
    <div class="bg-slate-950 border-b border-slate-800 pb-8 pt-6">
        <div class="container mx-auto px-4 max-w-7xl">

            <!-- Breadcrumbs -->
            <div class="text-[11px] text-slate-400 font-medium mb-4 flex items-center gap-2">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-accent-500 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
                <i class="fa-solid fa-chevron-left text-[8px] opacity-50"></i>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'video' ) ); ?>" class="hover:text-accent-500 transition-colors"><?php esc_html_e( 'المكتبة المرئية', 'almukaddem' ); ?></a>
                <?php if ( $series_link ) : ?>
                <i class="fa-solid fa-chevron-left text-[8px] opacity-50"></i>
                <a href="<?php echo esc_url( $series_link ); ?>" class="hover:text-accent-500 transition-colors"><?php echo esc_html( $series_name ); ?></a>
                <?php endif; ?>
                <i class="fa-solid fa-chevron-left text-[8px] opacity-50"></i>
                <span class="text-white font-bold"><?php the_title(); ?></span>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Video Player -->
                <div class="w-full lg:w-[70%]">
                    <div class="aspect-video-container bg-black rounded-2xl overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.5)] border border-slate-800">
                        <?php if ( $video_url ) : ?>
                            <?php echo wp_oembed_get( esc_url( $video_url ) ); // supports YouTube/Vimeo embeds ?>
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <div class="player-mockup">
                                <?php the_post_thumbnail( 'large', array( 'class' => 'absolute inset-0 w-full h-full object-cover opacity-70' ) ); ?>
                            </div>
                        <?php else : ?>
                            <div class="player-mockup flex items-center justify-center">
                                <div class="absolute inset-0 bg-gradient-to-tr from-slate-900 to-primary-900"></div>
                                <div class="w-20 h-20 bg-accent-600/90 hover:bg-accent-500 text-white rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-white/20 transition-transform hover:scale-110">
                                    <i class="fa-solid fa-play ml-2 text-3xl"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Meta -->
                    <div class="mt-5">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <?php
                            if ( $cats && ! is_wp_error( $cats ) ) :
                                echo '<span class="bg-accent-600/20 text-accent-400 border border-accent-600/30 text-[10px] font-bold px-2 py-1 rounded">' . esc_html( $cats[0]->name ) . '</span>';
                            endif;
                            ?>
                            <?php if ( $series_name ) : ?>
                                <span class="bg-slate-800 text-slate-300 text-[10px] font-bold px-2 py-1 rounded"><?php echo esc_html( $series_name ); ?></span>
                            <?php endif; ?>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 leading-tight"><?php the_title(); ?></h1>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-5 border-b border-slate-800">
                            <div class="flex items-center gap-6 text-sm text-slate-400 font-serif">
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-accent-600"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-eye text-accent-600"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?> <?php esc_html_e( 'مشاهدة', 'almukaddem' ); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if ( $audio_dl ) : ?>
                                <a href="<?php echo esc_url( $audio_dl ); ?>" download class="h-10 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold transition-colors flex items-center gap-2 border border-slate-700"><i class="fa-solid fa-headphones"></i> <?php esc_html_e( 'تحميل MP3', 'almukaddem' ); ?></a>
                                <?php endif; ?>
                                <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_the_permalink() ); ?>" target="_blank" class="h-10 px-4 rounded-xl bg-accent-600 hover:bg-accent-500 text-white text-sm font-bold transition-colors flex items-center gap-2 border border-accent-500"><i class="fa-solid fa-share-nodes"></i> <?php esc_html_e( 'مشاركة', 'almukaddem' ); ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Playlist / Series -->
                <?php if ( $series && ! is_wp_error( $series ) ) :
                    $playlist = new WP_Query( array(
                        'post_type'      => 'video',
                        'posts_per_page' => 10,
                        'tax_query'      => array( array( 'taxonomy' => 'video_series', 'field' => 'term_id', 'terms' => $series[0]->term_id ) ),
                        'orderby'        => 'date',
                        'order'          => 'ASC',
                    ) );
                    if ( $playlist->have_posts() ) : ?>
                    <div class="w-full lg:w-[30%] flex flex-col h-[500px] lg:h-auto">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl flex flex-col h-full overflow-hidden">
                            <div class="p-4 bg-slate-800/50 border-b border-slate-800">
                                <h3 class="font-bold text-white text-sm"><?php echo esc_html( $series_name ); ?></h3>
                                <p class="text-[10px] text-slate-400 mt-1 font-serif"><?php echo esc_html( $series[0]->count ); ?> <?php esc_html_e( 'حلقة', 'almukaddem' ); ?></p>
                            </div>
                            <div class="flex-1 overflow-y-auto custom-scroll p-2 space-y-1">
                                <?php while ( $playlist->have_posts() ) : $playlist->the_post();
                                    $is_current = ( get_the_ID() === get_queried_object_id() );
                                ?>
                                    <a href="<?php the_permalink(); ?>" class="flex gap-3 p-2 rounded-xl <?php echo $is_current ? 'bg-primary-900/40 border border-primary-700/50 relative overflow-hidden' : 'hover:bg-slate-800 border border-transparent'; ?> transition-colors group">
                                        <?php if ( $is_current ) : ?><div class="absolute left-0 top-0 bottom-0 w-1 bg-accent-500"></div><?php endif; ?>
                                        <div class="relative w-28 aspect-video bg-slate-800 rounded-lg overflow-hidden flex-shrink-0">
                                            <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'almukaddem-thumb', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/40 transition-opacity"><i class="fa-solid fa-play text-white"></i></div>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h4 class="text-xs font-bold <?php echo $is_current ? 'text-white' : 'text-slate-300 group-hover:text-white'; ?> transition-colors leading-snug line-clamp-2"><?php the_title(); ?></h4>
                                            <?php if ( $is_current ) : ?><span class="text-[10px] text-accent-400 mt-1">▶ <?php esc_html_e( 'قيد التشغيل', 'almukaddem' ); ?></span><?php endif; ?>
                                        </div>
                                    </a>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif;
                endif; ?>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto px-4 max-w-7xl py-8" x-data="{ activeTab: 'desc' }">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-[70%]">
                <!-- Tabs -->
                <div class="flex gap-6 border-b border-slate-200 mb-6">
                    <button @click="activeTab = 'desc'" class="pb-3 text-sm font-bold transition-all border-b-2" :class="activeTab === 'desc' ? 'border-primary-700 text-primary-900' : 'border-transparent text-slate-500 hover:text-slate-800'"><i class="fa-solid fa-info-circle ml-1"></i> <?php esc_html_e( 'وصف المحاضرة', 'almukaddem' ); ?></button>
                    <button @click="activeTab = 'transcript'" class="pb-3 text-sm font-bold transition-all border-b-2" :class="activeTab === 'transcript' ? 'border-primary-700 text-primary-900' : 'border-transparent text-slate-500 hover:text-slate-800'"><i class="fa-solid fa-file-lines ml-1"></i> <?php esc_html_e( 'التفريغ النصي', 'almukaddem' ); ?></button>
                </div>

                <div x-show="activeTab === 'desc'" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <div class="article-content prose prose-slate prose-lg max-w-none font-serif text-slate-700 leading-loose">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div x-show="activeTab === 'transcript'" style="display:none;" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <div class="article-content prose prose-slate prose-lg max-w-none font-serif text-slate-800 leading-loose">
                        <?php $transcript = almukaddem_get_field( 'video_transcript' ); ?>
                        <?php if ( $transcript ) : echo wp_kses_post( wpautop( $transcript ) ); else : the_content(); endif; ?>
                    </div>
                </div>

                <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
            </div>

            <!-- Secondary Sidebar -->
            <div class="w-full lg:w-[30%] space-y-6">
                <!-- Downloads -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="bg-primary-50 px-4 py-3 border-b border-primary-100">
                        <h3 class="font-bold text-primary-900 text-sm flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-down text-accent-600"></i> <?php esc_html_e( 'ملفات التحميل', 'almukaddem' ); ?></h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <?php
                        $pdf = almukaddem_get_field( 'transcript_pdf' );
                        if ( $pdf ) :
                            $pdf_url = is_array( $pdf ) ? $pdf['url'] : $pdf; ?>
                            <a href="<?php echo esc_url( $pdf_url ); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center text-lg group-hover:bg-red-500 group-hover:text-white transition-colors"><i class="fa-regular fa-file-pdf"></i></div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-700"><?php esc_html_e( 'التفريغ النصي', 'almukaddem' ); ?></h4>
                                        <span class="text-[10px] text-slate-400 font-serif">PDF</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-download text-slate-300 group-hover:text-primary-600 transition-colors"></i>
                            </a>
                        <?php endif;
                        if ( $audio_dl ) : ?>
                            <a href="<?php echo esc_url( $audio_dl ); ?>" download class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-lg group-hover:bg-primary-600 group-hover:text-white transition-colors"><i class="fa-solid fa-file-audio"></i></div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-700"><?php esc_html_e( 'نسخة صوتية', 'almukaddem' ); ?></h4>
                                        <span class="text-[10px] text-slate-400 font-serif">MP3</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-download text-slate-300 group-hover:text-primary-600 transition-colors"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <h3 class="font-bold text-slate-800 text-sm mb-4"><?php esc_html_e( 'الكلمات الدلالية', 'almukaddem' ); ?></h3>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        if ( $cats && ! is_wp_error( $cats ) ) :
                            foreach ( $cats as $c ) :
                                echo '<a href="' . esc_url( get_term_link( $c ) ) . '" class="bg-slate-50 border border-slate-100 hover:border-primary-300 hover:text-primary-700 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">' . esc_html( $c->name ) . '</a>';
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
endwhile;
get_footer();
