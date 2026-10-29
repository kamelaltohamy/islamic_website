<?php
/**
 * Audio Series taxonomy template (سلسلة علمية صوتية).
 *
 * @package almukaddem
 */

get_header();

$term = get_queried_object();
$series_count = $term->count;
?>

    <main class="container mx-auto px-4 py-8 max-w-6xl" x-data="seriesPageData()">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-500 font-medium mb-6 flex items-center gap-2 flex-wrap">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="hover:text-primary-700 transition-colors"><?php esc_html_e( 'المكتبة الصوتية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php echo esc_html( single_term_title( '', false ) ); ?></span>
        </div>

        <!-- SERIES HERO -->
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 rounded-3xl p-6 md:p-10 mb-8 relative overflow-hidden shadow-xl border-t-4 border-accent-600 flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 w-32 h-32 md:w-40 md:h-40 flex-shrink-0 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl flex items-center justify-center shadow-inner group">
                <div class="absolute inset-0 bg-gradient-to-tr from-accent-600/20 to-transparent rounded-2xl"></div>
                <i class="fa-solid fa-book-open-reader text-5xl md:text-6xl text-accent-400 group-hover:scale-110 transition-transform duration-500"></i>
            </div>
            <div class="relative z-10 flex-grow text-center md:text-right">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-4">
                    <span class="bg-accent-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm"><i class="fa-solid fa-check-circle ml-1"></i> <?php esc_html_e( 'سلسلة صوتية', 'almukaddem' ); ?></span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-snug"><?php echo esc_html( single_term_title( '', false ) ); ?></h1>
                <?php if ( term_description( $term ) ) : ?>
                    <p class="text-primary-100 font-serif leading-relaxed mb-6 max-w-3xl text-sm md:text-base"><?php echo wp_kses_post( wp_strip_all_tags( term_description( $term ) ) ); ?></p>
                <?php endif; ?>
                <div class="flex flex-col sm:flex-row items-center gap-6 justify-between border-t border-white/10 pt-6">
                    <div class="flex items-center gap-6 text-sm text-white font-serif">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-accent-400"><i class="fa-solid fa-list-ol"></i></div>
                            <div><strong class="block text-white text-xs font-sans"><?php echo esc_html( $series_count ); ?></strong><span class="text-[10px] text-primary-200"><?php esc_html_e( 'درس صوتي', 'almukaddem' ); ?></span></div>
                        </div>
                    </div>
                    <?php
                    $first_lesson = new WP_Query( array(
                        'post_type'      => 'audio',
                        'posts_per_page' => 1,
                        'tax_query'      => array( array( 'taxonomy' => 'audio_series', 'field' => 'term_id', 'terms' => $term->term_id ) ),
                        'orderby'        => 'date',
                        'order'          => 'ASC',
                    ) );
                    if ( $first_lesson->have_posts() ) : $first_lesson->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="w-full sm:w-auto bg-accent-600 hover:bg-accent-500 text-white font-bold px-8 py-3 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 group border border-accent-500 hover:-translate-y-1">
                            <i class="fa-solid fa-play group-hover:scale-110 transition-transform"></i> <?php esc_html_e( 'ابدأ الاستماع', 'almukaddem' ); ?>
                        </a>
                    <?php wp_reset_postdata(); endif; ?>
                </div>
            </div>
        </div>

        <!-- CONTENT GRID -->
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- LESSONS LIST -->
            <section class="w-full lg:w-2/3 order-2 lg:order-1 flex flex-col gap-6">
                <!-- Playlist Controls -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="relative w-full sm:w-1/2">
                        <input type="text" x-model="searchQuery" placeholder="<?php esc_attr_e( 'ابحث عن درس في هذه السلسلة...', 'almukaddem' ); ?>" class="w-full bg-slate-50 text-sm font-medium rounded-xl py-2.5 px-4 pl-10 border border-slate-200 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                        <i class="fa-solid fa-search absolute left-4 top-3 text-slate-400"></i>
                    </div>
                </div>

                <!-- Lessons -->
                <div class="flex flex-col gap-3">
                    <?php
                    $i = 0;
                    if ( have_posts() ) :
                        while ( have_posts() ) : the_post(); $i++;
                            $duration = almukaddem_get_field( 'audio_duration' );
                    ?>
                        <div data-title="<?php the_title_attribute(); ?>" :class="matchesSearch ? '' : 'hidden'" class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white rounded-2xl border border-slate-100 hover:border-primary-300 hover:shadow-md transition-all gap-4">
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="w-12 h-12 flex-shrink-0 rounded-xl bg-primary-50 text-primary-700 font-bold flex items-center justify-center text-lg border border-primary-100 group-hover:bg-primary-700 group-hover:text-white transition-colors">
                                    <?php echo esc_html( sprintf( '%02d', $i ) ); ?>
                                </div>
                                <div>
                                    <a href="<?php the_permalink(); ?>" class="font-bold text-slate-800 text-sm hover:text-primary-700 transition-colors line-clamp-1 mb-1"><?php the_title(); ?></a>
                                    <div class="flex items-center gap-4 text-[11px] text-slate-400 font-serif">
                                        <?php if ( $duration ) : ?><span><i class="fa-regular fa-clock text-accent-600 ml-1"></i> <?php echo esc_html( $duration ); ?></span><?php endif; ?>
                                        <span><i class="fa-regular fa-calendar text-accent-600 ml-1"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end border-t sm:border-t-0 border-slate-50 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'transcripts' ) ) ? : get_post_type_archive_link( 'book' ) ); ?>" class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-primary-700 transition-colors" title="<?php esc_attr_e( 'قراءة التفريغ', 'almukaddem' ); ?>"><i class="fa-solid fa-file-lines"></i></a>
                                <?php $au = almukaddem_get_audio_url(); if ( $au ) : ?>
                                <a href="<?php echo esc_url( $au ); ?>" download class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-primary-700 transition-colors" title="<?php esc_attr_e( 'تحميل MP3', 'almukaddem' ); ?>"><i class="fa-solid fa-download"></i></a>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="w-10 h-10 rounded-full bg-accent-50 text-accent-700 flex items-center justify-center hover:bg-accent-600 hover:text-white transition-colors shadow-sm border border-accent-100 hover:border-accent-600 ml-2">
                                    <i class="fa-solid fa-play ml-0.5"></i>
                                </a>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else :
                        echo '<p class="text-slate-500">' . esc_html__( 'لا توجد دروس في هذه السلسلة بعد.', 'almukaddem' ) . '</p>';
                    endif;
                    ?>
                </div>

                <?php almukaddem_pagination(); ?>
            </section>

            <!-- SIDEBAR -->
            <aside class="w-full lg:w-1/3 order-1 lg:order-2 flex flex-col gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xl border-2 border-primary-200">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold block mb-0.5"><?php esc_html_e( 'الشارح', 'almukaddem' ); ?></span>
                        <h4 class="font-bold text-primary-900 text-sm"><?php bloginfo( 'name' ); ?></h4>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="text-[11px] text-accent-700 hover:underline mt-1 inline-block font-serif"><?php esc_html_e( 'عرض جميع السلاسل', 'almukaddem' ); ?></a>
                    </div>
                </div>

                <!-- Share -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <h3 class="font-bold text-slate-800 text-sm mb-4"><?php esc_html_e( 'مشاركة السلسلة', 'almukaddem' ); ?></h3>
                    <div class="flex gap-2">
                        <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_term_link( $term ) ); ?>" target="_blank" class="flex-1 bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white py-2 rounded-xl transition-colors flex items-center justify-center text-sm font-bold"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                        <a href="https://t.me/share/url?url=<?php echo rawurlencode( get_term_link( $term ) ); ?>" target="_blank" class="flex-1 bg-[#0088cc]/10 text-[#0088cc] hover:bg-[#0088cc] hover:text-white py-2 rounded-xl transition-colors flex items-center justify-center text-sm font-bold"><i class="fa-brands fa-telegram text-lg"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_term_link( $term ) ); ?>" target="_blank" class="flex-1 bg-[#1DA1F2]/10 text-[#1DA1F2] hover:bg-[#1DA1F2] hover:text-white py-2 rounded-xl transition-colors flex items-center justify-center text-sm font-bold"><i class="fa-brands fa-twitter text-lg"></i></a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script>
        function seriesPageData() {
            return {
                searchQuery: '',
                get matchesSearch() {
                    return true; // default; Alpine handles per-item via attribute binding workaround below
                }
            }
        }
    </script>
    <!-- Per-item search toggle: override hidden via JS -->
    <script>
        document.addEventListener('alpine:init', () => {
            window.seriesSearchInit = (el) => {
                const input = document.querySelector('[x-model="searchQuery"]');
                const items = document.querySelectorAll('[data-title]');
                if (input) {
                    input.addEventListener('input', () => {
                        const q = input.value.trim();
                        items.forEach(item => {
                            const title = item.getAttribute('data-title') || '';
                            item.style.display = (q === '' || title.indexOf(q) !== -1) ? '' : 'none';
                        });
                    });
                }
            };
        });
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.querySelector('[x-model="searchQuery"]');
            const items = document.querySelectorAll('[data-title]');
            if (input) {
                input.addEventListener('input', () => {
                    const q = input.value.trim();
                    items.forEach(item => {
                        const title = item.getAttribute('data-title') || '';
                        item.style.display = (q === '' || title.indexOf(q) !== -1) ? '' : 'none';
                    });
                });
            }
        });
    </script>

<?php
get_footer();
